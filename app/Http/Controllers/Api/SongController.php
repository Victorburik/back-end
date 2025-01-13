<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SongController extends Controller
{
    private function extractVideoId($url)
    {
        $match = preg_match('/(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches);
        return $match ? $matches[1] : null;
    }
    public function topMusicFromYouTube()
    {
        $apiKey = env('YOUTUBE_API_KEY');
        $videoIds = [
            'lkQaLTnmNFw',
            'zgpdENAlw4o',
            'y2dtkLvqkuw',
            'kICRJronm5Y',
            '4M7g7njJXJA',
        ];
        $approvedSuggestions = Suggestion::where('status', 'approved')->get();

        foreach ($approvedSuggestions as $suggestion) {
            $videoId = $this->extractVideoId($suggestion->link);
            if ($videoId) {
                $videoIds[] = $videoId;
            }
        }

        $response = Http::get('https://www.googleapis.com/youtube/v3/videos', [
            'part' => 'snippet,statistics',
            'id' => implode(',', $videoIds),
            'maxResults' => 50,
            'key' => $apiKey,
        ]);

        $items = $response->json()['items'];
        // dd($items);
        $videoDetails = [];
        foreach ($items as $video) {
            $videoId = $video['id'];
            $videoDetails[] = [
                'title' => $video['snippet']['title'],
                'videoId' => $videoId,
                'thumbnail' => $video['snippet']['thumbnails']['medium']['url'],
                'channel' => $video['snippet']['channelTitle'],
                'description' => $video['snippet']['description'],
                'views' => $video['statistics']['viewCount'] ?? 'N/A',
            ];
        }
    
        if (empty($videoDetails)) {
            return response()->json(['error' => 'Não foi possível obter as visualizações dos vídeos.'], 404);
        }
    
        return response()->json($videoDetails);
    }
    public function index()
    {
        return Song::paginate(5);
    }

    public function show($id)
    {
        return Song::findOrFail($id);
    }

    public function store(Request $request)
    {
        return Song::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $music = Song::findOrFail($id);
        $music->update($request->all());
        return $music;
    }

    public function destroy($id)
    {
        Song::destroy($id);
        return response()->json(['message' => 'Musica Deletada!']);
    }
}

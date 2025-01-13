<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Você não tem permissão para visualizar.',
            ], 403);
        }

        return response()->json(Suggestion::all());
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'songLink' => 'required|string',
            'songTitle' => 'required|string',
        ]);
        $user = $request->user();

        if (!$user || $user->role === 'user') {
            try {
                $suggestion = Suggestion::create([
                    'user_id' => Auth::id(),
                    'title' => $validated['songTitle'],
                    'link' => $validated['songLink'],
                    'status' => 'pending',
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Sugestão criada com sucesso!',
                    'data' => $suggestion,
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Erro ao criar sugestão. Tente novamente.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        } else if (!$user || $user->role === 'admin') {
            try {
                $suggestion = Suggestion::create([
                    'user_id' => Auth::id(),
                    'title' => $validated['songTitle'],
                    'link' => $validated['songLink'],
                    'status' => 'approved',
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Sugestão criada com sucesso!',
                    'data' => $suggestion,
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Erro ao criar sugestão. Tente novamente.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }

    public function approve(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Você não tem permissão para reprovar sugestões.',
            ], 403);
        }

        $suggestion = Suggestion::find($id);

        if (!$suggestion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sugestão não encontrada.',
            ], 404);
        }

        $suggestion->status = 'approved';
        $suggestion->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sugestão aprovada com sucesso!',
            'data' => $suggestion,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Você não tem permissão para reprovar sugestões.',
            ], 403);
        }

        $suggestion = Suggestion::find($id);

        if (!$suggestion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sugestão não encontrada.',
            ], 404);
        }

        $suggestion->status = 'rejected';
        $suggestion->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sugestão reprovada com sucesso!',
            'data' => $suggestion,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $suggestion = Suggestion::find($id);

        if (!$suggestion) {
            return response()->json(['message' => 'Sugestão não encontrada!'], 404);
        }

        if ($suggestion->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Você não tem permissão para deletar esta sugestão.',
            ], 403);
        }

        $suggestion->delete();

        return response()->json(['message' => 'Sugestão deletada com sucesso!']);
    }
    public function update(Request $request, $id)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Você não tem permissão para editar sugestões.',
            ], 403);
        }

        $validated = $request->validate([
            'songTitle' => 'nullable|string',
            'songLink' => 'nullable|string',
        ]);

        $suggestion = Suggestion::find($id);

        if (!$suggestion) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sugestão não encontrada.',
            ], 404);
        }

        $suggestion->title = $validated['songTitle'] ?? $suggestion->title;
        $suggestion->link = $validated['songLink'] ?? $suggestion->link;
        $suggestion->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sugestão atualizada com sucesso!',
            'data' => $suggestion,
        ]);
    }
}

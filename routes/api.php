<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SuggestionController;
use App\Models\Suggestion;
use App\Http\Controllers\Api\ApprovalController;
use App\Http\Controllers\Api\SongController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;


// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */



// /*
// |--------------------------------------------------------------------------
// | Rota para gerar o token CSRF ao front 
// |--------------------------------------------------------------------------
// */
Route::get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
});
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->tokens->each(function ($token) {
        $token->delete();
    });

    return response()->json(['message' => 'Logged out successfully']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/suggestions-create', [SuggestionController::class, 'create']);
    Route::post('/suggestions/{id}/approve', [SuggestionController::class, 'approve']);
    Route::post('/suggestions/{id}/reject', [SuggestionController::class, 'reject']);
    Route::get('/suggestions', [SuggestionController::class, 'index']);
    Route::put('/suggestions/{id}', [SuggestionController::class, 'update']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/approvals', [ApprovalController::class, 'index']);
    Route::patch('/approvals/{id}/approve', [ApprovalController::class, 'approve']);
    Route::patch('/approvals/{id}/reject', [ApprovalController::class, 'reject']);
});

Route::get('/songs', [SongController::class, 'topMusicFromYouTube']);
Route::get('/songs/{id}', [SongController::class, 'show']);
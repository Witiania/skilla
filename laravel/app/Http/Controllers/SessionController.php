<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function getSessions()
    {
        $user = Auth::user();

        // Получаем все токены пользователя
        $tokens = $user->tokens()->with('abilities')->get();

        return response()->json([
            'sessions' => $tokens,
        ]);
    }

    public function revokeSession($tokenId)
    {
        $user = Auth::user();

        // Находим токен по ID
        $token = $user->tokens()->where('id', $tokenId)->first();

        if ($token) {
            // Отзываем токен
            $token->delete();

            return response()->json([
                'message' => 'Session revoked successfully',
            ]);
        }

        return response()->json([
            'error' => 'Session not found',
        ], 404);
    }
}

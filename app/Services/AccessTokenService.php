<?php

namespace App\Services;

use App\Models\AccessToken;

class AccessTokenService
{
    public function createToken($length = 255)
    {
        $tokenLifeTime = config('auth.token_lifetime');

        return AccessToken::query()->create([
            'token' => unique_random(AccessToken::getTableName(), 'token', $length),
            'expires_at' => now()->addSeconds($tokenLifeTime),
        ]);
    }
}

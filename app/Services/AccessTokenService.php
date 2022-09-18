<?php

namespace App\Services;

use App\Exceptions\AccessTokenExpiredException;
use App\Exceptions\NoAccessTokenProvidedException;
use App\Exceptions\NotFoundAccessTokenException;
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

    public function check($token): void
    {
        throw_if(!$token, new NoAccessTokenProvidedException());

        $tokenModel = AccessToken::query()->findOr($token, function () {
            throw new NotFoundAccessTokenException();
        });

        throw_if($tokenModel->expires_at < now(), new AccessTokenExpiredException());
    }
}

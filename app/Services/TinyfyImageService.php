<?php

namespace App\Services;

use function Tinify\fromFile;
use function Tinify\setKey;

class TinyfyImageService
{
    public function __construct()
    {
        setKey(config('services.tinyfy.key'));
    }

    public function handleUserPhoto($filePath)
    {
        $source = fromFile($filePath);

        $resized = $source->resize([
            'method' => 'cover',
            'width' => 70,
            'height' => 70,
        ]);

        return $resized->toFile($filePath);
    }
}

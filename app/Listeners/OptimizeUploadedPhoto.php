<?php

namespace App\Listeners;

use App\Events\PhotoUploadedEvent;
use App\Services\TinyfyImageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OptimizeUploadedPhoto implements ShouldQueue
{
    public $tinyfyImageService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TinyfyImageService $imageService)
    {
        $this->tinyfyImageService = $imageService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PhotoUploadedEvent  $event
     * @return void
     */
    public function handle(PhotoUploadedEvent $event)
    {
        $this->tinyfyImageService->handleUserPhoto($event->imagePath);
    }
}

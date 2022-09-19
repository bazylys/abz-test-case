<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class UsersCollection extends ResourceCollection
{
    public static $wrap = 'users';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(fn($user) => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'position' => $user->position->name,
            'position_id' => $user->position->id,
            'registration_timestamp' => $user->created_at?->timestamp,
            'photo' => Storage::disk('photos')->url($user->photo),
        ]);
    }

    public function paginationInformation($request, $paginated, $default): array
    {
        return [
            'page' => $paginated['current_page'],
            'total_pages' => $paginated['last_page'],
            'total_users' => $paginated['total'],
            'count' => $paginated['to'] - $paginated['from'] + 1,
            'links' => [
                'prev' => $paginated['prev_page_url'] ?? null,
                'next' => $paginated['next_page_url'] ?? null,
            ]
        ];
    }
}

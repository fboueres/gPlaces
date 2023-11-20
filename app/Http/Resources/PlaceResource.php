<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'slug' => $this->slug,
            'city' => $this->city,
            'state' => $this->state,
            'links' => [
                'self' => route('places.show', ['place' => $this->slug]),
                'update' => route('places.update', ['place' => $this->slug]),
                'delete' => route('places.destroy', ['place' => $this->slug]),
            ],
        ];
    }
}

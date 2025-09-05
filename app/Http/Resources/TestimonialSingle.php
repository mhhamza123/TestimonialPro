<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialSingle extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'image' => $this->when(
                $this->hasMedia('person'),
                $this->getFirstMediaUrl('person'),
                asset('images/default.png')
            ),
            'message' => $this->message,
            'status' => $this->status
        ];
    }
}

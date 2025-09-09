<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
                            return [
            "id" => $this->id,
            "content" => $this->content,
            'post_id' => $this->post_id,
            'user_id' => $this->user_id,
            // "email" => Auth::user()->email,
            // "user_id" => Auth::user()->id,
            "name" => Auth::user()->name ?? null,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

        ];
    }
}

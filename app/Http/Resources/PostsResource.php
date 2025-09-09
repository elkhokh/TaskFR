<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
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
            "title" => $this->title,
            "content" => $this->content,
            "email" => Auth::user()->email,
            "user_id" => Auth::user()->id,
            "name" => Auth::user()->name,
            "image" => $this->whenNotNull($this->image),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

        ];
    }
}

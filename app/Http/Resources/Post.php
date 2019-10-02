<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'user' => new User($this->user),
            'title' => $this->title,
            'content' => $this->content,
            'type' => $this->type,
            'post_date' => $this->post_date,
            'created_at' => $this->created_at,
        ];
    }
}

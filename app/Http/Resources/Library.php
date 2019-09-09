<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Library extends JsonResource
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
            'owner' => $this->owner,
            'description' => $this->description,
            'type' => $this->type,
            'establish_date' => $this->establish_date,
            'created_at' => $this->created_at,
        ];
    }
}

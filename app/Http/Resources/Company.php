<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Company extends JsonResource
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
            'name' => $this->name,
            'owner_name' => $this->owner_name,
            'owner_phone' => $this->owner_phone,
            'address' => $this->address,
            'type' => $this->type,
            'establish_date' => $this->establish_date,
            'logo' => $this->logo,
            'created_at' => $this->created_at,
        ];
    }
}

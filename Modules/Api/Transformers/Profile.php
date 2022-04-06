<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            // "user" => new ProfileUser($this->whenLoaded('user')),
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "profile_pic_id" => $this->profile_pic_id,
        ];
    }
}

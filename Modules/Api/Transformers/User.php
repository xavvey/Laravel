<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Api\Transformers\Profile as ProfileResource;
use Modules\Api\Transformers\UserProfile;

class User extends JsonResource
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
            "password" => $this->password,
            "email" => $this->email,
            "phone" => $this->phone,
            "profile" => new ProfileResource($this->whenLoaded('profile')),
            // "profile" => new UserProfile($this->profile),
        ];
    }
}

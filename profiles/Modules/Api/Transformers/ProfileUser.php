<?php

namespace Modules\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileUser extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
        ];
    }
}

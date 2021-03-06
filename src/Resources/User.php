<?php

namespace Mrba\LaraStart\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'id' => $this->id,
            'nick_name' => $this->nick_name,
            'gender' => $this->gender,
            'country' => $this->country,
            'province' => $this->province,
            'city' => $this->city,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

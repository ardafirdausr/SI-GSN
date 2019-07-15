<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'NIP' => $this->NIP,
            'username' => $this->username,
            'nama' => $this->nama,
            'foto' => asset($this->foto),
            'access_role' => $this->getRoleNames()->first(),
            'permission' => $this->getAllPermissions()
        ];
    }
}

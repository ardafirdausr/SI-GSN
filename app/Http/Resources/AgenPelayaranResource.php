<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgenPelayaranResource extends JsonResource
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
            'nama' => $this->nama,
            'logo' => $this->logo,
            'alamat' => $this->alamat,
            'telepon' => $this->telepon,
            'loket' => $this->loket,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }
}

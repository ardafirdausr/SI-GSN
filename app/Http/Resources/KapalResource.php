<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KapalResource extends JsonResource
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
            'kode' => $this->kode,
            'nama' => $this->nama,
            'agen_pelayaran' => [
                'id' => $this->agen_pelayaran->id,
                'nama' => $this->agen_pelayaran->nama,
                'logo' => $this->agen_pelayaran->logo,
                'loket' => $this->agen_pelayaran->loket
            ],
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }
}
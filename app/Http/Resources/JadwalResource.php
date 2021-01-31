<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
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
            'waktu' => $this->waktu,
            'kota' => $this->kota,
            'status_kegiatan' => $this->status_kegiatan,
            'status_kapal' => $this->status_kapal,
            'status_tiket' => $this->status_tiket,
            'kapal' => [
                'id' => $this->kapal->id,
                'nama' => $this->kapal->nama,
            ],
            'agen_pelayaran' => [
                'id' => $this->kapal->agen_pelayaran->id,
                'nama' => $this->kapal->agen_pelayaran->nama,
                'logo' => asset($this->kapal->agen_pelayaran->logo),
                'loket' => $this->kapal->agen_pelayaran->loket
            ],
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
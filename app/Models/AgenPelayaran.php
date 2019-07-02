<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgenPelayaran extends Model
{
    public $table = 'agen_pelayaran';

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'loket'
    ];

    public function kapal(){
        return $this->hasMany(Kapal::class, 'id_agen_pelayaran', 'id');
    }

    public function jadwal(){
        return $this->hasManyThrough(
            Jadwal::class,
            Kapal::class,
            'id_agen_pelayaran',
            'id_kapal',
            'id',
            'id'
        );
    }
}

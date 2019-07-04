<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{

    public $table = 'jadwal';
    protected $fillable = [
        'id',
        'waktu',
        'kota',
        'status_kegiatan',
        'status_kapal',
        'status_tiket',
        'id_kapal'
    ];

    public function kapal(){
        return $this->belongsTo(Kapal::class, 'id_kapal', 'id');
    }

}
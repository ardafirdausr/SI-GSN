<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{

    public $table = 'jadwal';
    protected $fillable = [
        'id',
        'asal',
        'tujuan',
        'keberangkatan',
        'kedatangan',
        'status',
        'id_kapal',
    ];

    public function kapal(){
        return $this->belongsTo(Kapal::class, 'id_kapal', 'id');
    }
}
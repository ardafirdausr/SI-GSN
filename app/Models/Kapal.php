<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kapal extends Model
{
    public $table = 'kapal';

    protected $fillable = ['kode', 'nama', 'id_maskapai'];

    public function maskapai(){
        return $this->belongsTo(Maskapai::class, 'id_maskapai', 'id');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'id_kapal', 'id');
    }
}

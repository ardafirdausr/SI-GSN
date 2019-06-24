<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maskapai extends Model
{
    public $table = 'maskapai';

    protected $fillable = ['nama', 'loket'];

    public function kapal(){
        return $this->hasMany(Kapal::class, 'id_maskapai', 'id');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'id_maskapai', 'id');
    }
}

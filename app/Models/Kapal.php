<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kapal extends Model
{
    public $table = 'kapal';

    protected $fillable = ['kode', 'nama', 'id_agen_pelayaran'];

    public function agen_pelayaran(){
        return $this->belongsTo(AgenPelayaran::class, 'id_agen_pelayaran', 'id');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'id_kapal', 'id');
    }
}

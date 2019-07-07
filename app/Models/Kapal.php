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

    public function log_aktivitas(){
        return $this->morphToMany(LogAktivitas::class, 'log');
    }

    public static function boot(){
        parent::boot();
        static::created(function($kapal){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $kapal->log_aktivitas()->create([
                'aktivitas' => "$authUser telah menambahkan kapal baru dengan id : $kapal->id"
            ]);
        });
        static::updated(function($kapal){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $kapal->log_aktivitas()->create([
                'aktivitas' => "$authUser telah mengupdate kapal baru dengan id : $kapal->id"
            ]);
        });
        static::deleted(function($kapal){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $kapal->log_aktivitas()->create([
                'aktivitas' => "$authUser telah menghapus kapal baru dengan id : $kapal->id"
            ]);
        });
    }
}

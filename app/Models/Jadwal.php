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

    public function log_aktivitas(){
        return $this->morphToMany(LogAktivitas::class, 'log');
    }

    public static function boot(){
        parent::boot();
        static::created(function($jadwal){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $jadwal->log_aktivitas()->create([
                'aktivitas' => "$authUser telah menambahkan jadwal baru dengan id : $jadwal->id"
            ]);
        });
        static::updated(function($jadwal){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $jadwal->log_aktivitas()->create([
                'aktivitas' => "$authUser telah mengupdate jadwal baru dengan id : $jadwal->id"
            ]);
        });
        static::deleted(function($jadwal){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $jadwal->log_aktivitas()->create([
                'aktivitas' => "$authUser telah menghapus jadwal baru dengan id : $jadwal->id"
            ]);
        });
    }
}
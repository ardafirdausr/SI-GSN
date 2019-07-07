<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgenPelayaran extends Model
{
    public $table = 'agen_pelayaran';

    protected $fillable = [
        'nama',
        'logo',
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

    public function log_aktivitas(){
        return $this->morphToMany(LogAktivitas::class, 'log');
    }

    public static function boot(){
        parent::boot();
        static::created(function($agenPelayaran){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $agenPelayaran->log_aktivitas()->create([
                'aktivitas' => "$authUser telah menambahkan agen pelayaran dengan id : $agenPelayaran->id"
            ]);
        });
        static::updated(function($agenPelayaran){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $agenPelayaran->log_aktivitas()->create([
                'aktivitas' => "$authUser telah mengupdate agen pelayaran dengan id : $agenPelayaran->id"
            ]);
        });
        static::deleted(function($agenPelayaran){
            $authUser = auth()->user();
            $authUser = $authUser ? $authUser->username : 'Anonim';
            $agenPelayaran->log_aktivitas()->create([
                'aktivitas' => "$authUser telah menghapus agen pelayaran dengan id : $agenPelayaran->id"
            ]);
        });
    }
}

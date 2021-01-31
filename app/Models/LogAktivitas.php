<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'aktivitas',
        'log_id',
        'log_type',
        'created_at'
    ];

    public $timestamps = false;

    public $created_at = 'created_at';

    public function logable(){
        return $this->morphTo();
    }

    public function jadwal(){
        return BelongsToMorph::build($this, Jadwal::class, 'logable');
    }

    public function agen_pelayaran(){
        return BelongsToMorph::build($this, AgenPelayaran::class, 'logable');
    }
}

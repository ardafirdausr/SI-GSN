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
}

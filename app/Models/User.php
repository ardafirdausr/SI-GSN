<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'NIP',
        'username',
        'foto',
        // 'email',
        'password',
        'access_role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function log_aktivitas(){
        return $this->morphToMany(LogAktivitas::class, 'log');
    }

    public function getAccessRoleAttribute($value){
        return Str::title($value);
    }

    public function setNamaAttribute($value){
        $this->attributes['nama'] = Str::title($value);
    }

    // public static function boot(){
    //     parent::boot();
    //     static::created(function($user){
    //         $authUser = auth()->user();
    //         $authUser = $authUser ? $authUser->username : 'Anonim';
    //         $user->log_aktivitas()->create([
    //             'aktivitas' => "$authUser telah menambahkan user baru dengan id : $user->id"
    //         ]);
    //     });
    //     static::updated(function($user){
    //         $authUser = auth()->user();
    //         $authUser = $authUser ? $authUser->username : 'Anonim';
    //         $user->log_aktivitas()->create([
    //             'aktivitas' => "$authUser telah mengupdate user baru dengan id : $user->id"
    //         ]);
    //     });
    //     static::deleted(function($user){
    //         $authUser = auth()->user();
    //         $authUser = $authUser ? $authUser->username : 'Anonim';
    //         $user->log_aktivitas()->create([
    //             'aktivitas' => "$authUser telah menghapus user baru dengan id : $user->id"
    //         ]);
    //     });
    // }
}

<?php

namespace Tests\Unit\Models;

use Tests\ModelTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class UserTest extends ModelTestCase {

    public function test_model_configuration(){
        $model = new User();
        $fillable = [
            'nama',
            'NIP',
            'username',
            'foto',
            'password',
            // 'access_role',
        ];
        $hidden = [
            'password',
            'remember_token'
        ];
        $casts = [
            'email_verified_at' => 'datetime',
            'id' => 'int'
        ];
        $this->runConfigurationAssertions($model, $fillable, $hidden, ['*'], [], $casts);
    }

}

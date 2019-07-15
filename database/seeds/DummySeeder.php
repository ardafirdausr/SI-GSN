<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // creating dummy users
        $roles = ['petugas terminal', 'petugas agen', 'admin'];
        foreach($roles as $role){
            $user = factory('App\Models\User')->create(['username' => Str::camel($role.'1')]);
            $user->assignRole($role);
        }
        factory('App\Models\AgenPelayaran', 4)->create();
    }
}

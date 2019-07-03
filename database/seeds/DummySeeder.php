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
        $accessRoles = ['petugas terminal', 'petugas agen', 'admin'];
        foreach($accessRoles as $accessRole){
            factory('App\Models\User', 3)->create(['access_role' => $accessRole]);
            factory('App\Models\User', 1)->create([
                'username' => Str::camel($accessRole.'1'),
                'access_role' => $accessRole
            ]);
        }
        factory('App\Models\AgenPelayaran', 4)->create();
    }
}

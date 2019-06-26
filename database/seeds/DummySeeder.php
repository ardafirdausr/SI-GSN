<?php

use Illuminate\Database\Seeder;
use App\Models;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        factory('App\Models\User', 3)->create();
        $maskapaiCollection = factory('App\Models\Maskapai', 3)->create();
        foreach($maskapaiCollection as $maskapai){
            $kapalCollection = $maskapai->kapal()->saveMany(factory('App\Models\Kapal', 5)->make());
            foreach($kapalCollection as $kapal){
                $jadwal = $kapal->jadwal()->save(factory('App\Models\Jadwal')->make());
            }
        }
    }
}

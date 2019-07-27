<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Kapal;
use App\Models\Jadwal;

use Tests\ModelTestCase;

class JadwalTest extends ModelTestCase{

    /**
     * Test model has
     */
    public function test_model_configuration(){
        $model = new Jadwal();
        $fillable = [
            'id',
            'waktu',
            'kota',
            'status_kegiatan',
            'status_kapal',
            'status_tiket',
            'kapal_id'
        ];
        $this->runConfigurationAssertions($model, $fillable);
    }

    public function test_it_belongs_to_kapal(){
        $kapal = new Kapal();
        $jadwal = new Jadwal();
        $belongsToRelation = $jadwal->kapal();
        $foreignKey = 'kapal_id';
        $this->assertBelongsToRelation($belongsToRelation, $jadwal, $kapal, $foreignKey);
    }
}

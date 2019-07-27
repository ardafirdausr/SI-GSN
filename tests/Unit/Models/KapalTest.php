<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\AgenPelayaran;
use App\Models\Kapal;
use App\Models\Jadwal;

use Tests\ModelTestCase;

class KapalTest extends ModelTestCase{

    public function test_model_configuration(){
        $model = new Kapal();
        $fillable = ['nama', 'agen_pelayaran_id'];
        $this->runConfigurationAssertions($model, $fillable);
    }

    public function test_it_has_many_jadwal_relation(){
        $kapal = new kapal();
        $jadwal = new Jadwal();
        $foreignKey = 'kapal_id';
        $hasManyRelation = $kapal->jadwal();
        $this->assertHasManyRelation($hasManyRelation, $kapal, $jadwal);
    }

    public function test_it_belongs_to_agen_pelayaran(){
        $kapal = new Kapal();
        $agenPelayaran = new AgenPelayaran();
        $foreignKey = 'agen_pelayaran_id';
        $belongsToRelation = $kapal->agen_pelayaran();
        $this->assertBelongsToRelation($belongsToRelation, $kapal, $agenPelayaran, $foreignKey);
    }

}

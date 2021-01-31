<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\AgenPelayaran;
use App\Models\Kapal;
use App\Models\Jadwal;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\ModelTestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgenPelayaranTest extends ModelTestCase{

    public function test_model_configuration(){
        $model = new AgenPelayaran;
        $fillable = ['nama', 'logo', 'alamat', 'telepon', 'loket'];
        $this->runConfigurationAssertions($model, $fillable);
    }

    public function test_it_has_many_kapal_relation(){
        $agenPelayaran = new AgenPelayaran();
        $kapal = $agenPelayaran->kapal();
        $this->assertHasManyRelation($kapal, $agenPelayaran, new Kapal());
    }

    public function test_it_has_many_jadwal_relation_through_kapal_model(){
        $agenPelayaran = new AgenPelayaran();
        $jadwal = new Jadwal();
        $pivot = new Kapal();
        $relation = $agenPelayaran->jadwal();
        $pivotForeignKey = 'agen_pelayaran_id';
        $relatedForeignKey = 'kapal_id';
        $this->assertHasManyThroughRelation(
            $relation,
            $agenPelayaran,
            $jadwal,
            $pivot,
            $pivotForeignKey,
            $relatedForeignKey
        );
    }

}

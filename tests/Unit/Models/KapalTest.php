<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\AgenPelayaran;
use App\Models\Kapal;
use App\Models\Jadwal;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\ModelTestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KapalTest extends ModelTestCase{

    public function test_model_configuration(){
        $model = new Kapal();
        $fillable = ['kode', 'nama', 'agen_pelayaran_id'];
        $this->runConfigurationAssertions($model, $fillable);
    }

    public function test_it_has_many_jadwal_relation(){
        $kapal = new kapal();
        $hasManyRelation = $kapal->jadwal();
        $this->assertHasManyRelation($hasManyRelation, $kapal, new Jadwal());
    }

    public function test_it_belongs_to_agen_pelayaran(){
        $kapal = new Kapal();
        $agenPelayaran = new AgenPelayaran();
        $foreignKey = 'agen_pelayaran_id';
        $belongsToRelation = $kapal->agen_pelayaran();
        $this->assertBelongsToRelation($belongsToRelation, $kapal, $agenPelayaran, $foreignKey);
        $this->assertInstanceOf(BelongsTo::class, $belongsToRelation);
        // $this->assertInstanceOf($agenPelayaran, $belongsToRelation->getRelated());
        $this->assertEquals($foreignKey, $belongsToRelation->getForeignKeyName());
        $this->assertTrue(Schema::hasColumns($belongsToRelation->getParent()->getTable(), [$foreignKey]));
    }

}

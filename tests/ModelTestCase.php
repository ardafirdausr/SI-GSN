<?php
namespace Tests;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

abstract class ModelTestCase extends TestCase
{
    /**
     * @param Model $model
     * @param array $fillable
     * @param array $guarded
     * @param array $hidden
     * @param array $visible
     * @param array $casts
     * @param array $dates
     * @param string $collectionClass
     * @param null $table
     * @param string $primaryKey
     * @param null $connection
     *
     * - `$fillable` -> `getFillable()`
     * - `$guarded` -> `getGuarded()`
     * - `$table` -> `getTable()`
     * - `$primaryKey` -> `getKeyName()`
     * - `$connection` -> `getConnectionName()`: in case multiple connections exist.
     * - `$hidden` -> `getHidden()`
     * - `$visible` -> `getVisible()`
     * - `$casts` -> `getCasts()`: note that method appends incrementing key.
     * - `$dates` -> `getDates()`: note that method appends `[static::CREATED_AT, static::UPDATED_AT]`.
     * - `newCollection()`: assert collection is exact type. Use `assertEquals` on `get_class()` result, but not `assertInstanceOf`.
     */
    protected function runConfigurationAssertions(
        Model $model,
        $fillable = [],
        $hidden = [],
        $guarded = ['*'],
        $visible = [],
        $casts = ['id' => 'int'],
        $dates = ['created_at', 'updated_at'],
        $collectionClass = Collection::class,
        $table = null,
        $primaryKey = 'id',
        $connection = null
    )
    {
        $this->assertEquals($fillable, $model->getFillable());
        $this->assertEquals($guarded, $model->getGuarded());
        $this->assertEquals($hidden, $model->getHidden());
        $this->assertEquals($visible, $model->getVisible());
        $this->assertEquals($casts, $model->getCasts());
        $this->assertEquals($dates, $model->getDates());
        $this->assertEquals($primaryKey, $model->getKeyName());
        $c = $model->newCollection();
        $this->assertEquals($collectionClass, get_class($c));
        $this->assertInstanceOf(Collection::class, $c);
        if ($connection !== null) {
            $this->assertEquals($connection, $model->getConnectionName());
        }
        if ($table !== null) {
            $this->assertEquals($table, $model->getTable());
        }
    }
    /**
     * @param HasMany $relation
     * @param Model $model
     * @param Model $related
     * @param string $foreignKey
     * @param string $parentPrimaryKey
     * @param \Closure $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKey()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentaiton).
     * - `getQualifiedParentKeyName()`: in case of `HasOneOrMany` relation, there is no `getLocalKey()` method, so this one should be asserted.
     */
    protected function assertHasManyRelation($relation, Model $model, Model $related, $foreignKey = null, $parentPrimaryKey = null, \Closure $queryCheck = null)
    {
        if (!is_null($queryCheck)) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }
        if (is_null($foreignKey)) {
            $foreignKey = $model->getForeignKey();
        }
        if (is_null($parentPrimaryKey)) {
            $parentPrimaryKey = $model->getKeyName();
        }
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals($model, $relation->getParent());
        $this->assertEquals($related, $relation->getRelated());
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertEquals($model->getTable().'.'.$parentPrimaryKey, $relation->getQualifiedParentKeyName());
    }

    /**
     * @param BelongsTo $relation
     * @param Model $model
     * @param Model $related
     * @param string $foreignKey
     * @param string $ownerPrimaryKey
     * @param \Closure $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKey()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentaiton).
     * - `getOwnerKey()`: `BelongsTo` relation and its extendings.
     */
    protected function assertBelongsToRelation($relation, Model $model, Model $related, $foreignKey, $ownerPrimaryKey = null, \Closure $queryCheck = null)
    {
        if (!is_null($queryCheck)) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }
        if (is_null($ownerPrimaryKey)) {
            $ownerPrimaryKey = $related->getKeyName();
        }
        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals($model, $relation->getParent());
        $this->assertEquals($related, $relation->getRelated());
        $this->assertEquals($foreignKey, $relation->getForeignKeyName());
        $this->assertEquals($ownerPrimaryKey, $relation->getOwnerKeyName());
    }

    /**
     * @param any $relation,
     * @param Model $model,
     * @param Model $related,
     * @param Model $pivot,
     * @param string $pivotForeignKey,
     * @param string $relatedForeignKey,
     * @param string $ownerPrimaryKey,
     * @param string $pivotPrimaryKey,
     * @param \Closure $queryCheck
     *
     * - `getQuery()`: assert query has not been modified or modified properly.
     * - `getForeignKey()`: any `HasOneOrMany` or `BelongsTo` relation, but key type differs (see documentaiton).
     * - `getOwnerKey()`: `BelongsTo` relation and its extendings.
     */
    protected function assertHasManyThroughRelation(
        $relation,
        Model $model,
        Model $related,
        Model $pivot,
        string $pivotForeignKey = null,
        string $relatedForeignKey = null,
        string $ownerPrimaryKey = null,
        string $pivotPrimaryKey = null,
        \Closure $queryCheck = null
    )
    {
        if (!is_null($queryCheck)) {
            $queryCheck->bindTo($this);
            $queryCheck($relation->getQuery(), $model, $relation);
        }
        if (is_null($ownerPrimaryKey)) {
            $ownerPrimaryKey = $related->getKeyName();
        }
        if(is_null($pivotPrimaryKey)){
            $pivotPrimaryKey = $pivot->getKeyName();
        }
        $this->assertInstanceOf(HasManyThrough::class, $relation);
        $this->assertEquals($pivot, $relation->getParent());
        $this->assertEquals($related, $relation->getRelated());
        $this->assertEquals($ownerPrimaryKey, $relation->getLocalKeyName());
        $this->assertEquals($relatedForeignKey, $relation->getForeignKeyName());
        $this->assertEquals($pivotForeignKey, $relation->getFirstKeyName());
    }

}
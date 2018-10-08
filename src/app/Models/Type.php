<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Type
 * @package Dekmabot\Catalog
 *
 * @property integer          $id
 * @property string          $name
 * @property boolean         $is_active
 *
 * @property-read Collection $options
 * @property-read Collection $rubrics
 */
class Type extends Model
{
    const TABLE = 'catalog_types';
    
    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_IS_ACTIVE = 'is_active';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_NAME      => 'string',
        self::FIELD_IS_ACTIVE => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_IS_ACTIVE,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class, TypeOption::TABLE)
            ->withPivot(TypeOption::FIELD_SORT)
            ->using(TypeOption::class)
            ->orderBy(TypeOption::FIELD_SORT, 'asc')
            ->withTimestamps();
    }
    
    /**
     * @deprecated
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rubrics()
    {
        return $this->belongsToMany(Rubric::class, TypeRubric::TABLE)
            ->using(TypeRubric::class)
            ->withTimestamps();
    }
    
}

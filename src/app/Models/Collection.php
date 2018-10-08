<?php

namespace Dekmabot\Catalog\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Collection
 * @package Dekmabot\Catalog
 *
 * @property integer   $id
 * @property integer   $pos
 * @property string    $slug
 * @property string    $name
 * @property string    $text
 * @property string    $image
 * @property boolean   $is_active
 *
 * @property-read Item $items
 */
class Collection extends Model
{
    use CrudTrait;
    
    const TABLE = 'catalog_collections';
    
    const FIELD_ID = 'id';
    const FIELD_POS = 'pos';
    const FIELD_SLUG = 'slug';
    const FIELD_NAME = 'name';
    const FIELD_TEXT = 'text';
    const FIELD_IMAGE = 'image';
    const FIELD_IS_ACTIVE = 'is_active';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_POS       => 'integer',
        self::FIELD_SLUG      => 'string',
        self::FIELD_NAME      => 'string',
        self::FIELD_TEXT      => 'string',
        self::FIELD_IMAGE     => 'string',
        self::FIELD_IS_ACTIVE => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_SLUG,
        self::FIELD_NAME,
        self::FIELD_TEXT,
        self::FIELD_IMAGE,
        self::FIELD_IS_ACTIVE,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, ItemCollection::TABLE)
            ->using(ItemCollection::class)
            ->withTimestamps();
    }
}

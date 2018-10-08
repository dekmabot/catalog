<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ItemCollection
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $collection_id
 * @property string  $value
 * @property string  $created_at
 * @property string  $updated_at
 */
class ItemCollection extends Pivot
{
    const TABLE = 'catalog_items_collections';
    
    const FIELD_ID = 'id';
    const FIELD_ITEM_ID = 'item_id';
    const FIELD_COLLECTION_ID = 'collection_id';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID            => 'integer',
        self::FIELD_ITEM_ID       => 'integer',
        self::FIELD_COLLECTION_ID => 'integer',
    ];
    
    protected $fillable = [
        self::FIELD_ITEM_ID,
        self::FIELD_COLLECTION_ID,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class, self::FIELD_ITEM_ID);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class, self::FIELD_COLLECTION_ID);
    }
}

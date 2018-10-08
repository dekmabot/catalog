<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ItemWarehouse
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $warehouse_id
 * @property string  $value
 * @property string  $created_at
 * @property string  $updated_at
 */
class ItemWarehouse extends Pivot
{
    const TABLE = 'catalog_items_warehouses';
    
    const FIELD_ID = 'id';
    const FIELD_ITEM_ID = 'item_id';
    const FIELD_WAREHOUSE_ID = 'warehouse_id';
    const FIELD_VALUE = 'value';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID           => 'integer',
        self::FIELD_ITEM_ID      => 'integer',
        self::FIELD_WAREHOUSE_ID => 'integer',
        self::FIELD_VALUE        => 'string',
    ];
    
    protected $fillable = [
        self::FIELD_ITEM_ID,
        self::FIELD_WAREHOUSE_ID,
        self::FIELD_VALUE,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}

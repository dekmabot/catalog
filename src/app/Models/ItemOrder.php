<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ItemOrder
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $item_id
 * @property integer $order_id
 * @property float   $price
 * @property integer $count
 * @property string  $created_at
 * @property string  $updated_at
 */
class ItemOrder extends Pivot
{
    const TABLE = 'catalog_items_orders';
    
    const FIELD_ID = 'id';
    const FIELD_ITEM_ID = 'item_id';
    const FIELD_ORDER_ID = 'order_id';
    const FIELD_PRICE = 'price';
    const FIELD_COUNT = 'count';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID       => 'integer',
        self::FIELD_ITEM_ID  => 'integer',
        self::FIELD_ORDER_ID => 'integer',
        self::FIELD_PRICE    => 'float',
        self::FIELD_COUNT    => 'integer',
    ];
    
    protected $fillable = [
        self::FIELD_ITEM_ID,
        self::FIELD_ORDER_ID,
        self::FIELD_PRICE,
        self::FIELD_COUNT,
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
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 * @package Dekmabot\Catalog
 *
 * @property integer     $id
 * @property integer     $item_id
 * @property integer     $order_id
 * @property integer     $user_id
 * @property string      $session
 * @property string      $price
 * @property integer     $count
 * @property string      $created_at
 * @property string      $updated_at
 *
 * @property-read Item[] $item
 */
class Cart extends Model
{
    const TABLE = 'catalog_carts';
    
    const FIELD_ID = 'id';
    const FIELD_ITEM_ID = 'item_id';
    const FIELD_ORDER_ID = 'order_id';
    const FIELD_USER_ID = 'user_id';
    const FIELD_SESSION = 'session';
    const FIELD_PRICE = 'price';
    const FIELD_COUNT = 'count';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID       => 'integer',
        self::FIELD_ORDER_ID => 'integer',
        self::FIELD_ITEM_ID  => 'integer',
        self::FIELD_USER_ID  => 'integer',
        self::FIELD_SESSION  => 'string',
        self::FIELD_PRICE    => 'string',
        self::FIELD_COUNT    => 'integer',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    static public function currentCart()
    {
        $sessionId = request()->session()->getId();
        
        /** @var Cart[] $carts */
        $carts = Cart::query()->with(['item', 'item.colors'])
            ->where(Cart::FIELD_SESSION, $sessionId)
            ->whereNull(Cart::FIELD_ORDER_ID)
            ->orderBy(Cart::FIELD_PRICE, 'DESC')
            ->get();
        
        return $carts;
    }
}

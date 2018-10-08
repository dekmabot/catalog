<?php

namespace Dekmabot\Catalog\app\Models;

use App\User;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $code
 * @property string  $first_name
 * @property string  $second_name
 * @property string  $surname
 * @property string  $phones
 * @property string  $address
 * @property string  $city
 * @property integer $legal
 * @property integer $delivery
 * @property integer $status
 * @property string  $created_at
 * @property string  $updated_at
 * @property string  $count_items
 * @property string  $count_total
 * @property string  $sum
 *
 * @property-read Cart[] $carts
 */
class Order extends Model
{
    use CrudTrait;
    
    const TABLE = 'catalog_orders';
    
    const FIELD_ID = 'id';
    const FIELD_CODE = 'code';
    const FIELD_USER_ID = 'user_id';
    const FIELD_FIRST_NAME = 'first_name';
    const FIELD_SECOND_NAME = 'second_name';
    const FIELD_SURNAME = 'surname';
    const FIELD_PHONES = 'phones';
    const FIELD_ADDRESS = 'address';
    const FIELD_LEGAL = 'legal';
    const FIELD_CITY = 'city';
    const FIELD_DELIVERY = 'delivery';
    const FIELD_STATUS = 'status';
    const FIELD_COUNT_ITEMS = 'count_items';
    const FIELD_COUNT_TOTAL = 'count_total';
    const FIELD_SUM = 'sum';
    
    const STATUS_NEW = 1;
    const STATUS_APPROVED = 100;
    const STATUS_READY = 200;
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID          => 'integer',
        self::FIELD_USER_ID     => 'integer',
        self::FIELD_CODE        => 'string',
        self::FIELD_FIRST_NAME  => 'string',
        self::FIELD_SECOND_NAME => 'string',
        self::FIELD_SURNAME     => 'string',
        self::FIELD_PHONES      => 'array',
        self::FIELD_ADDRESS     => 'string',
        self::FIELD_CITY        => 'string',
        self::FIELD_LEGAL       => 'integer',
        self::FIELD_DELIVERY    => 'integer',
        self::FIELD_STATUS      => 'integer',
        self::FIELD_COUNT_ITEMS => 'integer',
        self::FIELD_COUNT_TOTAL => 'integer',
        self::FIELD_SUM         => 'integer',
    ];
    
    protected $fillable = [
        self::FIELD_FIRST_NAME,
        self::FIELD_SECOND_NAME,
        self::FIELD_SURNAME,
        self::FIELD_PHONES,
        self::FIELD_ADDRESS,
        self::FIELD_CITY,
        self::FIELD_LEGAL,
        self::FIELD_DELIVERY,
        self::FIELD_COUNT_ITEMS,
        self::FIELD_COUNT_TOTAL,
        self::FIELD_SUM,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany(Cart::class, Cart::FIELD_ORDER_ID)
            ->with('item');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, Order::FIELD_USER_ID);
    }
}

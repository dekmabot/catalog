<?php

namespace Dekmabot\Catalog\app\Models;

use Backpack\CRUD\CrudTrait;
use Dekmabot\Maps\Models\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Warehouse
 * @package Dekmabot\Catalog
 *
 * @property integer     $id
 * @property integer     $point_id
 * @property string      $code
 * @property string      $name
 * @property string      $name_short
 * @property string      $slug
 * @property string      $pos
 * @property string      $text
 * @property string      $address
 * @property string      $phone
 * @property string      $phone2
 * @property string      $phone3
 * @property string      $working_hours_week
 * @property string      $working_hours_weekend
 * @property string      $image
 * @property boolean     $is_active
 * @property boolean     $is_main
 *
 * @property-read Item[] $items
 * @property-read Point  $point
 *
 * @method Builder ordered()
 */
class Warehouse extends Model
{
    use CrudTrait;
    
    const TABLE = 'catalog_warehouses';
    
    const FIELD_ID = 'id';
    const FIELD_POINT_ID = 'point_id';
    const FIELD_CODE = 'code';
    const FIELD_NAME = 'name';
    const FIELD_NAME_SHORT = 'name_short';
    const FIELD_SLUG = 'slug';
    const FIELD_POS = 'pos';
    const FIELD_TEXT = 'text';
    const FIELD_ADDRESS = 'address';
    const FIELD_PHONE = 'phone';
    const FIELD_PHONE2 = 'phone2';
    const FIELD_PHONE3 = 'phone3';
    const FIELD_WORKING_HOURS_WEEK = 'working_hours_week';
    const FIELD_WORKING_HOURS_WEEKEND = 'working_hours_weekend';
    const FIELD_IMAGE = 'image';
    const FIELD_IS_ACTIVE = 'is_active';
    const FIELD_IS_MAIN = 'is_main';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID                    => 'integer',
        self::FIELD_POINT_ID              => 'integer',
        self::FIELD_CODE                  => 'string',
        self::FIELD_NAME                  => 'string',
        self::FIELD_NAME_SHORT            => 'string',
        self::FIELD_SLUG                  => 'string',
        self::FIELD_POS                   => 'integer',
        self::FIELD_TEXT                  => 'string',
        self::FIELD_ADDRESS               => 'string',
        self::FIELD_PHONE                 => 'string',
        self::FIELD_PHONE2                => 'string',
        self::FIELD_PHONE3                => 'string',
        self::FIELD_WORKING_HOURS_WEEK    => 'string',
        self::FIELD_WORKING_HOURS_WEEKEND => 'string',
        self::FIELD_IMAGE                 => 'string',
        self::FIELD_IS_ACTIVE             => 'boolean',
        self::FIELD_IS_MAIN               => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_POINT_ID,
        self::FIELD_CODE,
        self::FIELD_NAME,
        self::FIELD_NAME_SHORT,
        self::FIELD_SLUG,
        self::FIELD_POS,
        self::FIELD_TEXT,
        self::FIELD_ADDRESS,
        self::FIELD_PHONE,
        self::FIELD_PHONE2,
        self::FIELD_PHONE3,
        self::FIELD_WORKING_HOURS_WEEK,
        self::FIELD_WORKING_HOURS_WEEKEND,
        self::FIELD_IS_ACTIVE,
        self::FIELD_IS_MAIN,
    ];
    
    static public function getEmpty()
    {
        $record = new self;
        $record->is_active = true;
        
        return $record;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, ItemWarehouse::TABLE)
            ->withPivot(ItemWarehouse::FIELD_VALUE)
            ->using(ItemWarehouse::class)
            ->withTimestamps();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function point()
    {
        return $this->belongsTo(Point::class);
    }
    
    public function available($itemId)
    {
        $available = $this->items()
            ->wherePivot(ItemWarehouse::FIELD_ITEM_ID, $itemId)
            ->withPivot(ItemWarehouse::FIELD_VALUE)
            ->first();
        
        if (null === $available) {
            return null;
        }else {
            return $available->pivot->value;
        }
    }
    
    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOrdered(Builder $query)
    {
        return $query->orderBy(Warehouse::FIELD_NAME, 'asc');
    }
    
    public function setPointIdAttribute($value)
    {
        if (isset($value['map_point'])) {
            $point = Point::savePoint($this, Warehouse::FIELD_POINT_ID, $value['map_point']);
            if (null === $point) {
                $this->attributes[Warehouse::FIELD_POINT_ID] = null;
            }else {
                $this->attributes[Warehouse::FIELD_POINT_ID] = $point->id;
            }
        }else {
            $this->attributes[Warehouse::FIELD_POINT_ID] = $value;
        }
    }
    
}

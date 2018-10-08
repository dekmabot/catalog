<?php

namespace Dekmabot\Catalog\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package Dekmabot\Catalog
 *
 * @property integer          $id
 * @property integer          $type_id
 * @property integer          $brand_id
 * @property integer          $rubric_id
 * @property integer          $supplier_id
 * @property string           $code
 * @property string           $name
 * @property string           $slug
 * @property string           $text
 * @property float            $price
 * @property string           $image
 * @property float            $rating
 * @property boolean          $is_active
 * @property boolean          $is_popular
 * @property boolean          $is_new
 *
 * @property-read Type        $type
 * @property-read Brand       $brand
 * @property-read Rubric      $rubric
 * @property-read Cart        $cart
 * @property-read Option[]    $options
 * @property-read Color[]     $colors
 * @property-read Warehouse[] $available
 * @property-read Warehouse   $availableOnWarehouse
 */
class Item extends Model
{
    use CrudTrait;
    
    const TABLE = 'catalog_items';
    
    const FIELD_ID = 'id';
    const FIELD_TYPE_ID = 'type_id';
    const FIELD_BRAND_ID = 'brand_id';
    const FIELD_RUBRIC_ID = 'rubric_id';
    const FIELD_SUPPLIER_ID = 'supplier_id';
    const FIELD_CODE = 'code';
    const FIELD_NAME = 'name';
    const FIELD_SLUG = 'slug';
    const FIELD_TEXT = 'text';
    const FIELD_PRICE = 'price';
    const FIELD_IMAGE = 'image';
    const FIELD_RATING = 'rating';
    const FIELD_IS_ACTIVE = 'is_active';
    const FIELD_IS_POPULAR = 'is_popular';
    const FIELD_IS_NEW = 'is_new';
    
    const INDEX_SEARCH = 'searchIndex';
    
    public $availableTotal = 0;
    
    static public $indexes = [
        self::INDEX_SEARCH => [
            Item::FIELD_RUBRIC_ID,
        ],
    ];
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID          => 'integer',
        self::FIELD_TYPE_ID     => 'integer',
        self::FIELD_BRAND_ID    => 'integer',
        self::FIELD_RUBRIC_ID   => 'integer',
        self::FIELD_SUPPLIER_ID => 'integer',
        self::FIELD_CODE        => 'string',
        self::FIELD_NAME        => 'string',
        self::FIELD_SLUG        => 'string',
        self::FIELD_TEXT        => 'string',
        self::FIELD_PRICE       => 'float',
        self::FIELD_IMAGE       => 'string',
        self::FIELD_RATING      => 'float',
        self::FIELD_IS_ACTIVE   => 'boolean',
        self::FIELD_IS_POPULAR  => 'boolean',
        self::FIELD_IS_NEW      => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_TYPE_ID,
        self::FIELD_BRAND_ID,
        self::FIELD_RUBRIC_ID,
        self::FIELD_SUPPLIER_ID,
        self::FIELD_CODE,
        self::FIELD_NAME,
        self::FIELD_SLUG,
        self::FIELD_TEXT,
        self::FIELD_PRICE,
        self::FIELD_IMAGE,
        self::FIELD_RATING,
        self::FIELD_IS_ACTIVE,
        self::FIELD_IS_POPULAR,
        self::FIELD_IS_POPULAR,
    ];
    
    static public function getEmpty()
    {
        $record = new self;
        $record->is_active = true;
        
        return $record;
    }
    
    public function showQuantity($quantity)
    {
        if ($quantity > 0 && $quantity < 1) {
            return 'нет';
        }elseif ($quantity <= 20) {
            return $quantity;
        }else {
            return 'много';
        }
    }
    
    public function myOption($slug)
    {
        return null;
        
        foreach ($this->options as $option) {
            if ($slug === $option->slug) {
                return $option->pivot->value;
            }
        }
        
        return null;
    }
    
    public function getMyRoute($is_admin = false)
    {
        if ($is_admin) {
            if ($this->id) {
                return route('admin.catalog_items.store', $this->type->id);
            }else {
                return route('admin.catalog_items.update', [$this->type->id, $this->id]);
            }
        }
        
        return '';
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cart()
    {
        return $this->hasOne(Cart::class)
            ->where(Cart::FIELD_SESSION, request()->session()->getId())
            ->whereNull(Cart::FIELD_ORDER_ID);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function options()
    {
        return $this->belongsToMany(Option::class, ItemOption::TABLE)
            ->using(ItemOption::class)
            ->withPivot(ItemOption::FIELD_VALUE)
            ->withTimestamps();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function colors()
    {
        return $this->belongsToMany(Color::class, ItemColor::TABLE)
            ->using(ItemColor::class)
            ->orderBy(Color::FIELD_POS, 'asc')
            ->withPivot(ItemColor::FIELD_IMAGE);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rubric()
    {
        return $this->belongsTo(Rubric::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function itemOptions()
    {
        return ItemOption::query()->where(ItemOption::FIELD_ITEM_ID, $this->id);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function available()
    {
        return $this->belongsToMany(Warehouse::class, ItemWarehouse::TABLE)
            ->withPivot(ItemWarehouse::FIELD_VALUE)
            ->using(ItemWarehouse::class)
            ->withTimestamps();
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function availableTotal()
    {
        $this->availableTotal = 0;
        foreach ($this->available as $warehouse) {
            $this->availableTotal += $warehouse->pivot->value;
        }
        
        return $this->availableTotal;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class, ItemCollection::TABLE)
            ->using(ItemCollection::class)
            ->withTimestamps();
    }
    
    /**
     * @param $warehouseId
     *
     * @return int
     */
    public function availableOnWarehouse($warehouseId)
    {
        $available = ItemWarehouse::query()
            ->where(ItemWarehouse::FIELD_ITEM_ID, $this->id)
            ->where(ItemWarehouse::FIELD_WAREHOUSE_ID, $warehouseId)
            ->firstOrNew([]);
        
        return (int)$available->value;
    }
    
    /**
     * @param string $session
     *
     * @return Cart|null
     */
    public function inCart($session)
    {
        /** @var Cart $cart */
        $cart = Cart::query()
            ->where(Cart::FIELD_ITEM_ID, $this->id)
            ->where(Cart::FIELD_SESSION, $session)
            ->first();
        
        return $cart;
    }
}

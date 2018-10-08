<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ItemOption
 * @package Dekmabot\Catalog
 *
 * @property integer     $id
 * @property integer      $item_id
 * @property integer      $option_id
 * @property string      $value
 *
 * @property-read Option $option
 */
class ItemOption extends Pivot
{
    const TABLE = 'catalog_items_options';
    
    const FIELD_ID = 'id';
    const FIELD_ITEM_ID = 'item_id';
    const FIELD_OPTION_ID = 'option_id';
    const FIELD_VALUE = 'value';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_ITEM_ID   => 'integer',
        self::FIELD_OPTION_ID => 'integer',
        self::FIELD_VALUE     => 'string',
    ];
    
    protected $fillable = [
        self::FIELD_ITEM_ID,
        self::FIELD_OPTION_ID,
        self::FIELD_VALUE,
    ];
    
    /**
     * @param Option $option
     *
     * @return ItemOption
     */
    static public function createFromOption(Option $option)
    {
        $value = new self;
        
        $value->value = '';
        $value->option()->associate($option);
        
        return $value;
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    
    /**
     * @param mixed $value
     */
    public function fromArray($value)
    {
        if (Option::TYPE_CHECKBOX_MULTI === $this->option->type) {
            $this->value = json_encode($value);
        }else {
            $this->value = $value;
        }
    }
    
}

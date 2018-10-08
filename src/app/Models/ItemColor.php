<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class ItemColor
 * @package Dekmabot\Catalog
 *
 * @property integer     $id
 * @property integer     $item_id
 * @property integer     $color_id
 * @property string      $image
 *
 * @property-read Option $option
 */
class ItemColor extends Pivot
{
    const TABLE = 'catalog_items_colors';
    
    const FIELD_ID = 'id';
    const FIELD_ITEM_ID = 'item_id';
    const FIELD_COLOR_ID = 'color_id';
    const FIELD_IMAGE = 'image';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID       => 'integer',
        self::FIELD_ITEM_ID  => 'integer',
        self::FIELD_COLOR_ID => 'integer',
        self::FIELD_IMAGE    => 'string',
    ];
    
    protected $fillable = [
        self::FIELD_ITEM_ID,
        self::FIELD_COLOR_ID,
        self::FIELD_IMAGE,
    ];
}

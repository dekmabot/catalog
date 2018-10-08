<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $pos
 * @property string  $name
 * @property string  $hex
 * @property boolean $is_active
 */
class Color extends Model
{
    const TABLE = 'catalog_colors';
    
    const FIELD_ID = 'id';
    const FIELD_POS = 'pos';
    const FIELD_NAME = 'name';
    const FIELD_HEX = 'hex';
    const FIELD_IS_ACTIVE = 'is_active';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_POS       => 'integer',
        self::FIELD_NAME      => 'string',
        self::FIELD_HEX       => 'string',
        self::FIELD_IS_ACTIVE => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_POS,
        self::FIELD_NAME,
        self::FIELD_HEX,
        self::FIELD_IS_ACTIVE,
    ];
}

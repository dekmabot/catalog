<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property string  $name
 * @property string  $slug
 * @property string  $text_short
 * @property string  $text_long
 * @property string  $image
 * @property string  $url
 * @property boolean $is_active
 */
class Brand extends Model
{
    const TABLE = 'catalog_brands';
    
    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_SLUG = 'slug';
    const FIELD_TEXT_SHORT = 'text_short';
    const FIELD_TEXT_LONG = 'text_long';
    const FIELD_IMAGE = 'image';
    const FIELD_URL = 'url';
    const FIELD_IS_ACTIVE = 'is_active';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID         => 'integer',
        self::FIELD_NAME       => 'string',
        self::FIELD_SLUG       => 'string',
        self::FIELD_TEXT_SHORT => 'string',
        self::FIELD_TEXT_LONG  => 'string',
        self::FIELD_IMAGE      => 'string',
        self::FIELD_URL        => 'string',
        self::FIELD_IS_ACTIVE  => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_SLUG,
        self::FIELD_TEXT_SHORT,
        self::FIELD_TEXT_LONG,
        self::FIELD_URL,
        self::FIELD_IS_ACTIVE,
    ];
    
    static public function getForSelect()
    {
        $list = self::query()->orderBy(self::FIELD_NAME, 'asc')->get();
        
        return array_pluck($list, 'name', 'id');
    }
}

<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Option
 * @package Dekmabot\Catalog
 *
 * @property integer  $id
 * @property string  $name
 * @property string  $slug
 * @property integer $type
 * @property array   $params
 * @property boolean $is_active
 */
class Option extends Model
{
    const TABLE = 'catalog_options';
    
    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_SLUG = 'slug';
    const FIELD_TYPE = 'type';
    const FIELD_PARAMS = 'params';
    const FIELD_IS_ACTIVE = 'is_active';
    
    const TYPE_STRING = 1;
    const TYPE_TEXT = 2;
    const TYPE_SELECT = 3;
    const TYPE_CHECKBOX = 4;
    const TYPE_CHECKBOX_MULTI = 5;
    const TYPE_IMAGE = 6;
    
    static public $types = [
        self::TYPE_STRING         => [
            'name' => 'Строка',
        ],
        self::TYPE_TEXT           => [
            'name' => 'Текст',
        ],
        self::TYPE_SELECT         => [
            'name' => 'Выпадающий список',
        ],
        self::TYPE_CHECKBOX       => [
            'name' => 'Галочка (да/нет)',
        ],
        self::TYPE_CHECKBOX_MULTI => [
            'name' => 'Несколько галочек',
        ],
        self::TYPE_IMAGE          => [
            'name' => 'Фотография',
        ],
    ];
    
    public $rules = [];
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_NAME      => 'string',
        self::FIELD_SLUG      => 'string',
        self::FIELD_TYPE      => 'integer',
        self::FIELD_PARAMS    => 'array',
        self::FIELD_IS_ACTIVE => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_SLUG,
        self::FIELD_TYPE,
        self::FIELD_IS_ACTIVE,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany(Type::class, TypeOption::TABLE)
            ->using(TypeOption::class)
            ->withTimestamps();
    }
    
    static public function getForSelect()
    {
        $result = [];
        foreach(self::$types as $key => $type){
            $result[$key] = $type['name'];
        }

        return $result;
    }
    
}

<?php

namespace Dekmabot\Catalog\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CalculationGroup
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property string  $name
 * @property boolean $is_active
 */
class CalculationGroup extends Model
{
    use CrudTrait;
    
    const TABLE = 'catalog_calculation_groups';
    
    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_IS_ACTIVE = 'is_active';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_NAME      => 'string',
        self::FIELD_IS_ACTIVE => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_IS_ACTIVE,
    ];
}

<?php

namespace Dekmabot\Catalog\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $name
 * @property integer $site
 * @property boolean $is_active
 */
class Supplier extends Model
{
    use CrudTrait;
    
    const TABLE = 'catalog_supplier';
    
    const FIELD_ID = 'id';
    const FIELD_NAME = 'name';
    const FIELD_SITE = 'site';
    const FIELD_IS_ACTIVE = 'is_active';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_NAME      => 'string',
        self::FIELD_SITE      => 'string',
        self::FIELD_IS_ACTIVE => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_SITE,
        self::FIELD_IS_ACTIVE,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplierGroup()
    {
        return $this->belongsTo(Supplier::class);
    }
}

<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class TypeOptions
 * @package Dekmabot\Catalog
 *
 * @property integer   $id
 * @property integer   $type_id
 * @property integer   $option_id
 * @property integer   $sort
 *
 * @property-read Type $type
 */
class TypeOption extends Pivot
{
    const TABLE = 'catalog_types_options';
    
    const FIELD_ID = 'id';
    const FIELD_TYPE_ID = 'type_id';
    const FIELD_OPTION_ID = 'option_id';
    const FIELD_SORT = 'sort';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_TYPE_ID   => 'integer',
        self::FIELD_OPTION_ID => 'integer',
        self::FIELD_SORT      => 'integer',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}

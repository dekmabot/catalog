<?php

namespace Dekmabot\Catalog\app\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class TypeRubric
 * @package Dekmabot\Catalog
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $rubric_id
 */
class TypeRubric extends Pivot
{
    const TABLE = 'catalog_types_rubrics';
    
    const FIELD_ID = 'id';
    const FIELD_TYPE_ID = 'type_id';
    const FIELD_RUBRIC_ID = 'rubric_id';
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID        => 'integer',
        self::FIELD_TYPE_ID   => 'integer',
        self::FIELD_RUBRIC_ID => 'integer',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    
}

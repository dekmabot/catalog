<?php

namespace Dekmabot\Catalog\app\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NestedSet;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Rubric
 * @package Dekmabot\Catalog
 *
 * @property integer      $id
 * @property integer      $parent_id
 * @property string       $name
 * @property string       $name_short
 * @property string       $slug
 * @property string       $text
 * @property string       $url
 * @property string       $image_promo
 * @property string       $image_announce
 * @property integer      $_lft
 * @property integer      $_rgt
 * @property boolean      $is_active
 *
 * @property-read Builder firstLevel()
 */
class Rubric extends Model
{
    use NodeTrait, CrudTrait;
    
    const TABLE = 'catalog_rubrics';
    
    const FIELD_ID = 'id';
    const FIELD_PARENT_ID = NestedSet::PARENT_ID;
    const FIELD_NAME = 'name';
    const FIELD_NAME_SHORT = 'name_short';
    const FIELD_SLUG = 'slug';
    const FIELD_TEXT = 'text';
    const FIELD_URL = 'url';
    const FIELD_IMAGE_PROMO = 'image_promo';
    const FIELD_IMAGE_ANNOUNCE = 'image_announce';
    const FIELD_NESTEDSETS_LEFT = NestedSet::LFT;
    const FIELD_NESTEDSETS_RIGHT = NestedSet::RGT;
    const FIELD_IS_ACTIVE = 'is_active';
    
    public $isSelected = false;
    
    protected $table = self::TABLE;
    
    protected $casts = [
        self::FIELD_ID             => 'integer',
        self::FIELD_PARENT_ID      => 'integer',
        self::FIELD_NAME           => 'string',
        self::FIELD_NAME_SHORT     => 'string',
        self::FIELD_SLUG           => 'string',
        self::FIELD_TEXT           => 'string',
        self::FIELD_URL            => 'string',
        self::FIELD_IMAGE_PROMO    => 'string',
        self::FIELD_IMAGE_ANNOUNCE => 'string',
        self::FIELD_IS_ACTIVE      => 'boolean',
    ];
    
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_NAME_SHORT,
        self::FIELD_SLUG,
        self::FIELD_TEXT,
        self::FIELD_IMAGE_PROMO,
        self::FIELD_IMAGE_ANNOUNCE,
        self::FIELD_IS_ACTIVE,
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types()
    {
        return $this->belongsToMany(Type::class, TypeRubric::TABLE)
            ->using(TypeRubric::class)
            ->withTimestamps();
    }
    
    public function getUrl()
    {
        /** @var Rubric[] $rubrics */
        $rubrics = $this->getAncestors()->all();
        
        $url = [];
        foreach ($rubrics as $rubric) {
            $url[] = $rubric->slug;
        }
        $url[] = $this->slug;
        
        return implode('/', $url);
    }
    
    public function updateUrl()
    {
        $this->url = $this->getUrl();
        $this->save();
    }
    
    static public function getForSelect($withLeaves = true)
    {
        /** @var Rubric[] $rubrics */
        $rubrics = Rubric::withDepth()->orderBy(Rubric::FIELD_NESTEDSETS_LEFT, 'asc')->get();
        $values = [];
        foreach ($rubrics as $rubric) {
            
            if (!$withLeaves && $rubric->isLeaf()) {
                continue;
            }
            
            $prefix = '';
            
            /** @var Rubric[] $ancentors */
            $ancentors = $rubric->getAncestors();
            foreach ($ancentors as $ancentor) {
                $prefix = $ancentor->name_short . '/';
            }
            
            $values[$rubric->id] = $prefix . $rubric->name_short;
        }
        
        return $values;
    }
}

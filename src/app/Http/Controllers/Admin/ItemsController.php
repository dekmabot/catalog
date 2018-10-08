<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Dekmabot\Catalog\app\Http\Requests\ItemRequest as StoreRequest;
use Dekmabot\Catalog\app\Http\Requests\ItemRequest as UpdateRequest;

use Dekmabot\Catalog\app\Models\Brand;
use Dekmabot\Catalog\app\Models\Collection;
use Dekmabot\Catalog\app\Models\Color;
use Dekmabot\Catalog\app\Models\Item;
use Dekmabot\Catalog\app\Models\ItemCollection;
use Dekmabot\Catalog\app\Models\ItemWarehouse;
use Dekmabot\Catalog\app\Models\Rubric;
use Dekmabot\Catalog\app\Models\Type;
use Dekmabot\Catalog\app\Models\Warehouse;
use Illuminate\Foundation\Http\FormRequest;

class ItemsController extends CrudController
{
    /**
     * @param bool $template_name
     *
     * @throws \Exception
     */
    public function setup($template_name = false)
    {
        parent::__construct();
        
        $modelClass = config('catalog.item_model_class', Item::class);
        
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/catalog/items');
        $this->crud->setEntityNameStrings(trans('catalog::item.name.singular'), trans('catalog::item.name.plural'));
        
        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'   => Item::FIELD_IMAGE,
                'label'  => trans('catalog::item.field.image'),
                'type'   => 'image',
                'height' => '150px',
                'prefix' => '/storage/' // in case you only store the filename in the database, this text will be prepended to the database value
            ],
            [
                'name'  => Item::FIELD_CODE,
                'label' => trans('catalog::item.field.code'),
            ],
            [
                'name'  => Item::FIELD_NAME,
                'label' => trans('catalog::item.field.name'),
            ],
            [
                'name'      => Item::FIELD_RUBRIC_ID,
                'label'     => trans('catalog::item.field.rubric'),
                'type'      => 'select',
                'entity'    => 'rubric',
                'attribute' => 'name',
                'model'     => Rubric::class,
            ],
            [
                'name'   => Item::FIELD_PRICE, // The db column name
                'label'  => trans('catalog::item.field.price'),
                'type'   => 'number',
                'suffix' => ' руб.',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        $this->crud->addFields([
            [
                'name'  => Item::FIELD_NAME,
                'label' => trans('catalog::item.field.name'),
                'type'  => 'text',
            ],
            [
                'name'  => Item::FIELD_CODE,
                'label' => trans('catalog::item.field.code'),
                'type'  => 'text',
            ],
            [
                'name'   => Item::FIELD_PRICE,
                'label'  => trans('catalog::item.field.price'),
                'type'   => 'number',
                'suffix' => ' руб.',
            ],
            [
                'name'  => Item::FIELD_TEXT,
                'label' => trans('catalog::item.field.text'),
                'type'  => 'textarea',
            ],
            [
                'name'      => Item::FIELD_RUBRIC_ID,
                'label'     => trans('catalog::item.field.rubric'),
                'type'      => 'select',
                'entity'    => 'rubric',
                'attribute' => 'name',
                'model'     => Rubric::class,
            ],
            [
                'name'      => Item::FIELD_BRAND_ID,
                'label'     => trans('catalog::item.field.brand'),
                'type'      => 'select',
                'entity'    => 'brand',
                'attribute' => 'name',
                'model'     => Brand::class,
            ],
            [
                'name'      => Item::FIELD_TYPE_ID,
                'label'     => trans('catalog::item.field.type'),
                'type'      => 'select',
                'entity'    => 'type',
                'attribute' => 'name',
                'model'     => Type::class,
            ],
            [
                'name'  => Item::FIELD_RATING,
                'label' => trans('catalog::item.field.rating'),
                'type'  => 'text',
            ],
            [       // SelectMultiple = n-n relationship (with pivot table)
                'label' => 'Colors',
                'type' => 'select2_multiple',
                'name' => 'colors', // the method that defines the relationship in your Model
                'entity' => 'colors', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => Color::class, // foreign key model
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            ],
            [
                'name'   => Item::FIELD_IMAGE,
                'label'  => trans('catalog::item.field.image'),
                'type'   => 'browse',
                'upload' => true,
                'crop'   => true,
                'prefix' => '/storage/',
            ],
            [   // Select2Multiple = n-n relationship (with pivot table)
                'label'     => 'Collections',
                'type'      => 'select2_multiple',
                'name'      => 'collections', // the method that defines the relationship in your Model
                'entity'    => 'collections', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => Collection::class, // foreign key model
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?
            ],
            [
                'name'  => 'warehouse',
                'label' => trans('catalog::item.field.warehouse'),
                'type'  => 'warehouses',
            ],
            [
                'name'  => Item::FIELD_IS_ACTIVE,
                'label' => trans('catalog::item.field.is_active'),
                'type'  => 'checkbox',
            ],
            [
                'name'  => Item::FIELD_IS_POPULAR,
                'label' => trans('catalog::item.field.is_popular'),
                'type'  => 'checkbox',
            ],
            [
                'name'  => Item::FIELD_IS_NEW,
                'label' => trans('catalog::item.field.is_new'),
                'type'  => 'checkbox',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */
        
        $this->crud->addFilter([ // simple filter
            'type'  => 'text',
            'name'  => Item::FIELD_CODE,
            'label' => 'Код товара',
        ],
            false,
            function ($value){ // if the filter is active
                $this->crud->addClause('where', Item::FIELD_CODE, 'LIKE', '%' . $value . '%');
            });
        
        $this->crud->addFilter([ // select2 filter
            'name'  => Item::FIELD_RUBRIC_ID,
            'type'  => 'select2',
            'label' => 'Рубрика',
        ], function (){
            $rubrics = Rubric::withDepth()->orderBy(Rubric::FIELD_NESTEDSETS_LEFT, 'asc')->get();
            $values = [];
            foreach ($rubrics as $rubric) {
                $values[$rubric->id] = str_repeat('> ', $rubric->depth) . $rubric->name;
            }
            
            return $values;
            
        }, function ($value){ // if the filter is active
            $this->crud->addClause('where', Item::FIELD_RUBRIC_ID, $value);
        });
        
        // In PageManager,
        // - default fields, that all templates are using, are set using $this->addDefaultPageFields();
        // - template-specific fields are set per-template, in the PageTemplates trait;
        
        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */
//        $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'beginning');
    }
    
    public function store(StoreRequest $request)
    {
        $result = parent::storeCrud($request);
        
        $this->storeWarehouses($request);
        
        return $result;
    }
    
    public function update(UpdateRequest $request)
    {
        $result = parent::updateCrud($request);
        
        $this->storeWarehouses($request);
        
        return $result;
    }
    
    private function storeWarehouses(FormRequest $request)
    {
        /** @var Item $item */
        $item = $this->data['entry'];
        
        $warehouses = $request->post('warehouse');
        
        foreach ($warehouses as $warehouseId => $value) {
            $value = intval($value);
            if ($value < 1) {
                $item->available()->detach($warehouseId);
            }else {
                $available = $item->available()->wherePivot(ItemWarehouse::FIELD_WAREHOUSE_ID, $warehouseId)->first();
                
                if (null === $available) {
                    $item->available()->attach($warehouseId, [ItemWarehouse::FIELD_VALUE => $value]);
                }else {
                    $item->available()->updateExistingPivot($warehouseId, [ItemWarehouse::FIELD_VALUE => $value]);
                }
            }
        }
    }
}

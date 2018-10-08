<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Dekmabot\Catalog\app\Http\Requests\WarehouseRequest as StoreRequest;
use Dekmabot\Catalog\app\Http\Requests\WarehouseRequest as UpdateRequest;

use Dekmabot\Catalog\app\Models\Warehouse;
use Dekmabot\Maps\Models\Point;

class WarehousesController extends CrudController
{
    /**
     * @param bool $template_name
     *
     * @throws \Exception
     */
    public function setup($template_name = false)
    {
        parent::__construct();
        
        $modelClass = config('catalog.warehouse_model_class', Warehouse::class);
        
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/catalog/warehouses');
        $this->crud->setEntityNameStrings(trans('catalog::warehouse.name.singular'), trans('catalog::warehouse.name.plural'));
        
        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'  => Warehouse::FIELD_POS,
                'label' => '№',
                'type'  => 'number',
            ],
            [
                'name'  => Warehouse::FIELD_NAME,
                'label' => trans('catalog::warehouse.field.name'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_ADDRESS,
                'label' => trans('catalog::warehouse.field.address'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_PHONE,
                'label' => trans('catalog::warehouse.field.phone'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_WORKING_HOURS_WEEK,
                'label' => trans('catalog::warehouse.field.working_hours_week'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_WORKING_HOURS_WEEKEND,
                'label' => trans('catalog::warehouse.field.working_hours_weekend'),
                'type'  => 'text',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        
        $this->crud->addFields([
            [
                'name'  => Warehouse::FIELD_NAME,
                'label' => trans('catalog::warehouse.field.name'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_NAME_SHORT,
                'label' => trans('catalog::warehouse.field.name_short'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_CODE,
                'label' => trans('catalog::warehouse.field.code'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_SLUG,
                'label' => trans('catalog::warehouse.field.slug'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_POS,
                'label' => trans('catalog::warehouse.field.pos'),
                'type'  => 'number',
            ],
            [
                'name'  => Warehouse::FIELD_TEXT,
                'label' => trans('catalog::warehouse.field.text'),
                'type'  => 'textarea',
            ],
            [
                'name'  => Warehouse::FIELD_ADDRESS,
                'label' => trans('catalog::warehouse.field.address'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_PHONE,
                'label' => trans('catalog::warehouse.field.phone'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_PHONE2,
                'label' => trans('catalog::warehouse.field.phone2'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_PHONE3,
                'label' => trans('catalog::warehouse.field.phone3'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_WORKING_HOURS_WEEK,
                'label' => trans('catalog::warehouse.field.working_hours_week'),
                'type'  => 'text',
            ],
            [
                'name'  => Warehouse::FIELD_WORKING_HOURS_WEEKEND,
                'label' => trans('catalog::warehouse.field.working_hours_weekend'),
                'type'  => 'text',
            ],
            [
                'name'   => Warehouse::FIELD_IMAGE,
                'label'  => trans('catalog::warehouse.field.image'),
                'type'   => 'browse',
                'upload' => true,
                'crop'   => true,
                'prefix' => '/storage/',
            ],
            [
                'name'  => Warehouse::FIELD_POINT_ID,
                'label' => trans('catalog::warehouse.field.point_id'),
                'type'  => 'map_point',
            ],
            [
                'name'  => Warehouse::FIELD_IS_ACTIVE,
                'label' => trans('catalog::warehouse.field.is_active'),
                'type'  => 'checkbox',
            ],
            [
                'name'  => Warehouse::FIELD_IS_MAIN,
                'label' => trans('catalog::warehouse.field.is_main'),
                'type'  => 'checkbox',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */
        /*
               $this->crud->addFilter([ // select2 filter
                   'name'  => Warehouse::FIELD_PARENT_ID,
                   'type'  => 'select2',
                   'label' => trans('catalog::warehouse.field.parent'),
               ], function (){
                   return Warehouse::getForSelect(false);
                   
               }, function ($value){ // if the filter is active
                   $this->crud->addClause('where', Warehouse::FIELD_PARENT_ID, $value);
               });
       */
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
        return parent::storeCrud($request);
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }
}

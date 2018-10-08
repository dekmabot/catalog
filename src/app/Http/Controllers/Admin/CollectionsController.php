<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Dekmabot\Catalog\app\Http\Requests\CollectionRequest as StoreRequest;
use Dekmabot\Catalog\app\Http\Requests\CollectionRequest as UpdateRequest;

use Dekmabot\Catalog\app\Models\Collection;

class CollectionsController extends CrudController
{
    /**
     * @param bool $template_name
     *
     * @throws \Exception
     */
    public function setup($template_name = false)
    {
        parent::__construct();
        
        $modelClass = config('catalog.collection_model_class', Collection::class);
        
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/catalog/collections');
        $this->crud->setEntityNameStrings(trans('catalog::collection.name.singular'), trans('catalog::collection.name.plural'));
        
        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'  => Collection::FIELD_NAME,
                'label' => trans('catalog::collection.field.name'),
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        $this->crud->addFields([
            [
                'name'  => Collection::FIELD_SLUG,
                'label' => trans('catalog::collection.field.slug'),
                'type'  => 'text',
            ],
            [
                'name'  => Collection::FIELD_NAME,
                'label' => trans('catalog::collection.field.name'),
                'type'  => 'text',
            ],
            [
                'name'  => Collection::FIELD_TEXT,
                'label' => trans('catalog::collection.field.text'),
                'type'  => 'textarea',
            ],
            [
                'name'   => Collection::FIELD_IMAGE,
                'label'  => trans('catalog::collection.field.image'),
                'type'   => 'browse',
                'upload' => true,
                'crop'   => true,
                'prefix' => '/storage/',
            ],
            [
                'name'  => Collection::FIELD_IS_ACTIVE,
                'label' => trans('catalog::collection.field.is_active'),
                'type'  => 'checkbox',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */
        
    }
    
    public function store(StoreRequest $request)
    {
        $result = parent::storeCrud($request);
    
        return $result;
    }
    
    public function update(UpdateRequest $request)
    {
        $result = parent::updateCrud($request);
        
        return $result;
    }
}

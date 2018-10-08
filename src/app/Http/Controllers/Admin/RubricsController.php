<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Dekmabot\Catalog\app\Http\Requests\RubricRequest as StoreRequest;
use Dekmabot\Catalog\app\Http\Requests\RubricRequest as UpdateRequest;

use Dekmabot\Catalog\app\Models\Rubric;

class RubricsController extends CrudController
{
    /**
     * @param bool $template_name
     *
     * @throws \Exception
     */
    public function setup($template_name = false)
    {
        parent::__construct();
        
        $modelClass = config('catalog.rubric_model_class', Rubric::class);
        
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/catalog/rubrics');
        $this->crud->setEntityNameStrings(trans('catalog::rubric.name.singular'), trans('catalog::rubric.name.plural'));
        
        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'   => Rubric::FIELD_IMAGE_PROMO,
                'label'  => trans('catalog::rubric.field.image_promo'),
                'type'   => 'image',
                'height' => '50px',
                'prefix' => '/storage/' // in case you only store the filename in the database, this text will be prepended to the database value
            ],
            [
                'name'   => Rubric::FIELD_IMAGE_ANNOUNCE,
                'label'  => trans('catalog::rubric.field.image_announce'),
                'type'   => 'image',
                'height' => '50px',
                'prefix' => '/storage/' // in case you only store the filename in the database, this text will be prepended to the database value
            ],
            [
                'name'  => Rubric::FIELD_NAME,
                'label' => trans('catalog::rubric.field.name'),
            ],
            [
                'name'      => Rubric::FIELD_PARENT_ID,
                'label'     => trans('catalog::rubric.field.parent'),
                'type'      => 'select',
                'entity'    => 'parent',
                'attribute' => 'name',
                'model'     => Rubric::class,
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        
        $this->crud->addFields([
            [
                'name'  => Rubric::FIELD_NAME,
                'label' => trans('catalog::rubric.field.name'),
                'type'  => 'text',
            ],
            [
                'name'  => Rubric::FIELD_NAME_SHORT,
                'label' => trans('catalog::rubric.field.name_short'),
                'type'  => 'text',
            ],
            [
                'name'  => Rubric::FIELD_SLUG,
                'label' => trans('catalog::rubric.field.slug'),
                'type'  => 'text',
            ],
            [
                'name'        => Rubric::FIELD_PARENT_ID,
                'label'       => trans('catalog::rubric.field.parent'),
                'type'        => 'select2_from_array',
                'options'     => Rubric::getForSelect(),
                'allows_null' => false,
            ],
            [
                'name'  => Rubric::FIELD_TEXT,
                'label' => trans('catalog::rubric.field.text'),
                'type'  => 'textarea',
            ],
            [
                'name'   => Rubric::FIELD_IMAGE_PROMO,
                'label'  => trans('catalog::rubric.field.image_promo'),
                'type'   => 'browse',
                'upload' => true,
                'crop'   => false,
                'prefix' => '/storage/',
            ],
            [
                'name'   => Rubric::FIELD_IMAGE_ANNOUNCE,
                'label'  => trans('catalog::rubric.field.image_announce'),
                'type'   => 'browse',
                'upload' => true,
                'crop'   => false,
                'prefix' => '/storage/',
            ],
            [
                'name'  => Rubric::FIELD_IS_ACTIVE,
                'label' => trans('catalog::rubric.field.is_active'),
                'type'  => 'checkbox',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */
        
        $this->crud->addFilter([ // select2 filter
            'name'  => Rubric::FIELD_PARENT_ID,
            'type'  => 'select2',
            'label' => trans('catalog::rubric.field.parent'),
        ], function (){
            return Rubric::getForSelect(false);
            
        }, function ($value){ // if the filter is active
            $this->crud->addClause('where', Rubric::FIELD_PARENT_ID, $value);
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
        return parent::storeCrud($request);
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud($request);
    }
    
    public function moveup($id)
    {
        /** @var Rubric $record */
        $record = Rubric::query()->findOrFail($id);
        $record->up();
        
        return redirect()->route('index');
    }
    
    public function movedown($id)
    {
        /** @var Rubric $record */
        $record = Rubric::query()->findOrFail($id);
        $record->down();
        
        return redirect()->route('index');
    }
}

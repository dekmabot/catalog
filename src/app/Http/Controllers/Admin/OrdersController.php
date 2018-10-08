<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Admin;

use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Dekmabot\Catalog\app\Http\Requests\OrderRequest as StoreRequest;
use Dekmabot\Catalog\app\Http\Requests\OrderRequest as UpdateRequest;

use Dekmabot\Catalog\app\Models\Order;

class OrdersController extends CrudController
{
    /**
     * @param bool $template_name
     *
     * @throws \Exception
     */
    public function setup($template_name = false)
    {
        parent::__construct();
        
        $modelClass = config('catalog.order_model_class', Order::class);
        
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel($modelClass);
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/catalog/orders');
        $this->crud->setEntityNameStrings(trans('catalog::order.name.singular'), trans('catalog::order.name.plural'));
        
        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumns([
            [
                'name'  => Order::FIELD_CODE,
                'label' => trans('catalog::order.field.code'),
                'type'  => 'number',
            ],
            [
                'name'  => 'created_at',
                'label' => trans('catalog::order.field.created_at'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_CITY,
                'label' => trans('catalog::order.field.city'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_ADDRESS,
                'label' => trans('catalog::order.field.address'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_COUNT_ITEMS,
                'label' => trans('catalog::order.field.count_items'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_COUNT_TOTAL,
                'label' => trans('catalog::order.field.count_total'),
                'type'  => 'text',
            ],
            [
                'name'     => Order::FIELD_SUM,
                'label'    => trans('catalog::order.field.sum'),
                'type'     => 'text',
                'suffix'   => ' руб.',
                'decimals' => 0,
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */
        
        $this->crud->addFields([
            [
                'name'  => Order::FIELD_CODE,
                'label' => trans('catalog::order.field.code'),
                'type'  => 'text',
            ],
            [
                'name'      => Order::FIELD_USER_ID,
                'label'     => trans('catalog::order.field.user_id'),
                'type'      => 'select2',
                'entity'    => 'user', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model'     => User::class // foreign key model
            ],
            [
                'name'  => Order::FIELD_FIRST_NAME,
                'label' => trans('catalog::order.field.first_name'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_SECOND_NAME,
                'label' => trans('catalog::order.field.second_name'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_SURNAME,
                'label' => trans('catalog::order.field.surname'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_PHONES,
                'label' => trans('catalog::order.field.phones'),
                'type'  => 'text',
            ],
            [
                'name'  => Order::FIELD_ADDRESS,
                'label' => trans('catalog::order.field.address'),
                'type'  => 'text',
            ],
            [
                'name'    => Order::FIELD_LEGAL,
                'label'   => trans('catalog::order.field.legal'),
                'type'    => 'select_from_array',
                'options' => [
                    1 => 'Физическое лицо',
                    2 => 'Юридическое лицо',
                ],
            ],
            [
                'name'  => Order::FIELD_CITY,
                'label' => trans('catalog::order.field.city'),
                'type'  => 'text',
            ],
            [
                'name'    => Order::FIELD_STATUS,
                'label'   => trans('catalog::order.field.status'),
                'type'    => 'select_from_array',
                'options' => [
                    Order::STATUS_NEW      => 'Новый',
                    Order::STATUS_APPROVED => 'Подтверждён',
                    Order::STATUS_READY    => 'Завершён',
                ],
            ],
            [
                'name'    => 'items',
                'label'   => trans('catalog::order.items'),
                'type'    => 'order_items',
            ],
        ]);
        
        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */
        /*
               $this->crud->addFilter([ // select2 filter
                   'name'  => Order::FIELD_PARENT_ID,
                   'type'  => 'select2',
                   'label' => trans('catalog::order.field.parent'),
               ], function (){
                   return Order::getForSelect(false);
                   
               }, function ($value){ // if the filter is active
                   $this->crud->addClause('where', Order::FIELD_PARENT_ID, $value);
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

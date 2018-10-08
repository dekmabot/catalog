<?php

return [
    
    // Change this class if you wish to extend CrudController
    'admin_items_controller_class'      => Dekmabot\Catalog\app\Http\Controllers\Admin\ItemsController::class,
    'admin_rubrics_controller_class'    => Dekmabot\Catalog\app\Http\Controllers\Admin\RubricsController::class,
    'admin_warehouses_controller_class' => Dekmabot\Catalog\app\Http\Controllers\Admin\WarehousesController::class,
    
    // Change this class if you wish to extend the model
    'brand_model_class'                 => Dekmabot\Catalog\app\Models\Brand::class,
    'cart_model_class'                  => Dekmabot\Catalog\app\Models\Cart::class,
    'color_model_class'                 => Dekmabot\Catalog\app\Models\Color::class,
    'item_model_class'                  => Dekmabot\Catalog\app\Models\Item::class,
    'itemcolor_model_class'             => Dekmabot\Catalog\app\Models\ItemColor::class,
    'itemoption_model_class'            => Dekmabot\Catalog\app\Models\ItemOption::class,
    'itemorder_model_class'             => Dekmabot\Catalog\app\Models\ItemOrder::class,
    'itemwarehouse_model_class'         => Dekmabot\Catalog\app\Models\ItemWarehouse::class,
    'option_model_class'                => Dekmabot\Catalog\app\Models\Option::class,
    'order_model_class'                 => Dekmabot\Catalog\app\Models\Order::class,
    'rubric_model_class'                => Dekmabot\Catalog\app\Models\Rubric::class,
    'type_model_class'                  => Dekmabot\Catalog\app\Models\Type::class,
    'typeoption_model_class'            => Dekmabot\Catalog\app\Models\TypeOption::class,
    'typerubric_model_class'            => Dekmabot\Catalog\app\Models\TypeRubric::class,
    'warehouse_model_class'             => Dekmabot\Catalog\app\Models\Warehouse::class,
];

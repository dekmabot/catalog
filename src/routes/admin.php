<?php

Route::group([
    'prefix'     => 'admin/catalog',
    'middleware' => [
        'web',
        'admin',
    ],
], function (){
    
    CRUD::resource('items', Dekmabot\Catalog\app\Http\Controllers\Admin\ItemsController::class);
    CRUD::resource('rubrics', Dekmabot\Catalog\app\Http\Controllers\Admin\RubricsController::class);
    CRUD::resource('warehouses', Dekmabot\Catalog\app\Http\Controllers\Admin\WarehousesController::class);
    CRUD::resource('collections', Dekmabot\Catalog\app\Http\Controllers\Admin\CollectionsController::class);
    CRUD::resource('orders', Dekmabot\Catalog\app\Http\Controllers\Admin\OrdersController::class);
    
    $controller = \Dekmabot\Catalog\app\Models\Item::class;
    Route::post('catalog/items/search', [
        'as'   => 'catalog.items.search',
        'uses' => $controller . '@search',
    ]);
    
    $controller = \Dekmabot\Catalog\app\Models\Rubric::class;
    Route::post('catalog/rubrics/search', [
        'as'   => 'catalog.rubrics.search',
        'uses' => $controller . '@search',
    ]);
    
    $controller = \Dekmabot\Catalog\app\Models\Warehouse::class;
    Route::post('catalog/warehouses/search', [
        'as'   => 'catalog.warehouses.search',
        'uses' => $controller . '@search',
    ]);
    
    $controller = \Dekmabot\Catalog\app\Models\Collection::class;
    Route::post('catalog/collections/search', [
        'as'   => 'catalog.collections.search',
        'uses' => $controller . '@search',
    ]);
    
    $controller = \Dekmabot\Catalog\app\Models\Order::class;
    Route::post('catalog/orders/search', [
        'as'   => 'catalog.orders.search',
        'uses' => $controller . '@search',
    ]);
    
});

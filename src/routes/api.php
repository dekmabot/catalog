<?php

const ROUTE_SITE_CATALOG_ITEM_POPUP = 'site.catalog_items.popup';

Route::group([
    'prefix'     => 'api',
    'middleware' => [
        'web',
    ],
], function (){
    Route::get('catalog/items/{slug}', 'Dekmabot\Catalog\app\Http\Controllers\Api\CatalogController@popup')->name(ROUTE_SITE_CATALOG_ITEM_POPUP);
});

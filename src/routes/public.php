<?php

const ROUTE_SITE_CATALOG_ITEMS_POPULAR = 'site.catalog_items.popular';
const ROUTE_SITE_CATALOG_ITEMS_NEW = 'site.catalog_items.new';
const ROUTE_SITE_CATALOG_ITEMS_SEARCH = 'site.catalog_items.search';
const ROUTE_SITE_CATALOG_RUBRICS_SHOW = 'site.catalog_rubrics.rubirc';
const ROUTE_SITE_CATALOG_SUBRUBRICS_SHOW = 'site.catalog_rubrics.subrubric';
const ROUTE_SITE_CATALOG_COLLECTIONS = 'site.catalog_collections.index';
const ROUTE_SITE_CATALOG_COLLECTIONS_SHOW = 'site.catalog_collections_show';
const ROUTE_SITE_CATALOG_ITEM_SHOW = 'site.catalog_items.show';
const ROUTE_SITE_CATALOG_CART = 'site.catalog_cart.index';
const ROUTE_SITE_CATALOG_CART_ORDER = 'site.catalog_cart.order';
const ROUTE_SITE_CATALOG_CART_THANKS = 'site.catalog_cart.thanks';

const ROUTE_SITE_MAP = 'static_map';

Route::group([
    'middleware' => [
        'web',
    ],
], function (){
    Route::get('catalog/popular', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@listPopular')->name(ROUTE_SITE_CATALOG_ITEMS_POPULAR);
    Route::get('catalog/new', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@listNew')->name(ROUTE_SITE_CATALOG_ITEMS_NEW);
    Route::get('catalog/search', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@search')->name(ROUTE_SITE_CATALOG_ITEMS_SEARCH);
    Route::get('catalog/rubrics/{slug}', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@listRubric')->name(ROUTE_SITE_CATALOG_RUBRICS_SHOW);
    Route::get('catalog/rubrics/{parent_slug}/{slug}', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@listSubRubric')->name(ROUTE_SITE_CATALOG_SUBRUBRICS_SHOW);
    Route::get('catalog/collections', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@listCollections')->name(ROUTE_SITE_CATALOG_COLLECTIONS);
    Route::get('catalog/collections/{slug}', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@listCollection')->name(ROUTE_SITE_CATALOG_COLLECTIONS_SHOW);
    
    Route::get('catalog/items/{slug}', 'Dekmabot\Catalog\app\Http\Controllers\Site\CatalogController@showItem')->name(ROUTE_SITE_CATALOG_ITEM_SHOW);
    Route::get('catalog/cart', 'Dekmabot\Catalog\app\Http\Controllers\Site\CartController@index')->name(ROUTE_SITE_CATALOG_CART);
    Route::any('catalog/cart/order', 'Dekmabot\Catalog\app\Http\Controllers\Site\CartController@order')->name(ROUTE_SITE_CATALOG_CART_ORDER);
    Route::get('catalog/cart/thanks', 'Dekmabot\Catalog\app\Http\Controllers\Site\CartController@thanks')->name(ROUTE_SITE_CATALOG_CART_THANKS);

    Route::get('/map', 'Dekmabot\Catalog\app\Http\Controllers\Site\WarehousesController@index')->name(ROUTE_SITE_MAP);
});
Route::group([
    'middleware' => [
        'web',
        'api',
    ],
], function (){
    Route::post('catalog/cart', 'Dekmabot\Catalog\app\Http\Controllers\Site\CartController@update')->name(ROUTE_SITE_CATALOG_CART);
});

<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Dekmabot\Catalog\app\Models\Collection;
use Dekmabot\Catalog\app\Models\Item;
use Dekmabot\Catalog\app\Models\Filters\ItemFilter;
use Dekmabot\Catalog\app\Models\Rubric;

class CatalogController extends Controller
{
    const PAGE_ANNOUNCE_LIMIT = 3;
    const PAGE_LIST_LIMIT = 15;
    
    public function listPopular()
    {
        $filter = new ItemFilter();
        $items = $filter->filter(Item::query());
        
        return view('app.catalog.list', [
            'items'  => $items,
            'filter' => $filter,
            'name'   => 'Популярные товары',
            
            'collections' => Collection::query()->inRandomOrder()->limit(3)->get(),
        ]);
    }
    
    public function listNew()
    {
        $filter = new ItemFilter();
        $items = $filter->filter(Item::query());
        
        return view('app.catalog.list', [
            'items'  => $items,
            'filter' => $filter,
            'name'   => 'Новые поступления',
            
            'collections' => Collection::query()->inRandomOrder()->limit(3)->get(),
        ]);
    }
    
    public function listRubric($slug)
    {
        /** @var Rubric $rubric */
        $rubric = Rubric::query()
            ->where(Rubric::FIELD_IS_ACTIVE, true)
            ->where(Rubric::FIELD_SLUG, $slug)
            ->firstOrFail();
        
        $filter = new ItemFilter();
        $items = $filter->filter(
            Item::query()
                ->where(Item::FIELD_RUBRIC_ID, $rubric->id)
        );
        
        return view('app.catalog.list', [
            'items'  => $items,
            'filter' => $filter,
            'name'   => $rubric->name,
            
            'collections' => Collection::query()->inRandomOrder()->limit(3)->get(),
        ]);
    }
    
    public function listCollections()
    {
        $collections = Collection::query()->get();
        
        return view('app.catalog.collections', [
            'collections' => $collections,
        ]);
    }
    
    public function listCollection($slug)
    {
        /** @var Collection $collection */
        $collection = Collection::query()->where(Collection::FIELD_SLUG, $slug)->firstOrFail();
        
        $filter = new ItemFilter();
        $items = $filter->filter($collection->items());
        
        return view('app.catalog.collection', [
            'items'  => $items,
            'filter' => $filter,
            
            'collection'  => $collection,
            'collections' => Collection::query()->inRandomOrder()->limit(3)->get(),
        ]);
    }
    
    public function search()
    {
        $filter = new ItemFilter();
        $items = $filter->filter(Item::query());
        
        return view('app.catalog.search', [
            'items'  => $items,
            'filter' => $filter,
            
            'collections' => Collection::query()->inRandomOrder()->limit(3)->get(),
        ]);
    }
    
    public function showItem($slug)
    {
        /** @var Item $item */
        $item = Item::query()->with('colors', 'available')
            ->where(Item::FIELD_IS_ACTIVE, true)
            ->where(Item::FIELD_SLUG, $slug)
            ->firstOrFail();
        
        foreach ($item->available as $warehouse) {
            $item->availableTotal += $warehouse->pivot->value;
        }
        
        $rubric = Rubric::query()->find($item->rubric_id);
        /** @var Rubric[] $breadcrumbs */
        $breadcrumbs = Rubric::query()->ancestorsAndSelf($rubric->id);
        
        $anotherItems = Item::query()
            ->where(Item::FIELD_RUBRIC_ID, $item->rubric_id)
            ->where(Item::FIELD_ID, '!=', $item->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();
        
        return view('app.catalog.content', [
            'item'        => $item,
            'rubric'      => $rubric,
            'breadcrumbs' => $breadcrumbs,
            
            
            'anotherItems' => $anotherItems,
            'collections'  => Collection::query()->inRandomOrder()->limit(3)->get(),
        ]);
    }
}

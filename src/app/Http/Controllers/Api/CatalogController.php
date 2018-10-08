<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Api;

use Dekmabot\Catalog\app\Models\Item;
use Dekmabot\Catalog\app\Models\Rubric;
use Dekmabot\Catalog\app\Models\Warehouse;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function popup($slug)
    {
        /** @var Item $item */
        $item = Item::query()->with('colors', 'available')
            ->where(Item::FIELD_IS_ACTIVE, true)
            ->where(Item::FIELD_SLUG, $slug)
            ->firstOrFail();
        
        /** @var Item[] $packs */
        $packs = Item::query()->with('colors', 'available')
            ->where(Item::FIELD_IS_ACTIVE, true)
            ->where(Item::FIELD_CODE, $item->code)
            ->orderBy(Item::FIELD_PRICE, 'ASC')
            ->get();
        
        foreach ($packs as $i => $pack) {
            /** @var Warehouse $warehouse */
            foreach ($pack->available as $warehouse) {
                $pack->availableTotal += $warehouse->pivot->value;
            }
            $packs[$i] = $pack;
        }
        
        $rubric = Rubric::query()->find($item->rubric_id);
        /** @var Rubric[] $breadcrumbs */
        $breadcrumbs = Rubric::query()->ancestorsAndSelf($rubric->id);
        unset($breadcrumbs[0]);
        
        $html = view('app.catalog.popup', [
            'item'        => $item,
            'packs'       => $packs,
            'rubric'      => $rubric,
            'breadcrumbs' => $breadcrumbs,
        ])->render();
        
        return [
            'html' => $html,
        ];
    }
}

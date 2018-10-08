<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Dekmabot\Catalog\app\Models\Warehouse;
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    public function index(Request $request)
    {
        $selected = $request->get('selected', null);
        $warehouses = Warehouse::query()->with('point')->get();
        
        return view('app.catalog.map', [
            'warehouses' => $warehouses,
            'selected'   => $selected,
        ]);
    }
}

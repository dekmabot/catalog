<?php

namespace Dekmabot\Catalog\Controllers\Api;

use Dekmabot\Admin\Controllers\AbstractSiteAdminController;
use Dekmabot\Catalog\app\Models\Option;
use Dekmabot\Catalog\app\Models\Type;
use Dekmabot\Catalog\app\Models\TypeOption;
use Illuminate\Http\Request;

class OptionsController extends AbstractSiteAdminController
{
    private $route_prefix = 'api.catalog_options.';
    
    public function index($type_id)
    {
        /** @var Type $type */
        $type = Type::query()->findOrFail($type_id);
        
        $fields = $type->options()->get();
        $templates = Option::query()->orderBy(Option::FIELD_NAME, 'asc')->get();
        
        return [
            'fields'    => $fields,
            'templates' => $templates,
            'types'     => Option::$types,
        ];
    }
    
    public function store($type_id, Request $request)
    {
        /** @var Type $type */
        $type = Type::query()->findOrFail($type_id);
        
        $option = new Option();
        
        $validator = \Validator::make($request->all(), $option->rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $option->name = $request->get(Option::FIELD_NAME);
        $option->type = $request->get(Option::FIELD_TYPE, 1);
        $option->params = $request->get(Option::FIELD_PARAMS, []);
        $option->is_active = 1;
        $option->save();
        
        $sort = $request->get(TypeOption::FIELD_SORT, 0);
        
        $type->options()->attach($option->id, [TypeOption::FIELD_SORT => $sort]);
        
        return response()->json($option);
    }
    
    public function update($type_id, $option_id, Request $request)
    {
        /** @var Type $type */
        $type = Type::query()->findOrFail($type_id);
        
        /** @var Option $option */
        $option = Option::query()->findOrFail($option_id);
        if (empty($type) || empty($option)) {
            return response()->json(['error' => ['name' => ['Запись не найдена']]], 200);
        }
        
        $validator = \Validator::make($request->all(), $option->rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        
        $option->name = $request->get(Option::FIELD_NAME);
        $option->type = $request->get(Option::FIELD_TYPE, 1);
        $option->params = $request->get(Option::FIELD_PARAMS, []);
        $option->is_active = 1;
        $option->save();
        
        $sort = $request->get(TypeOption::FIELD_SORT, 0);
        
        if ($type->options->contains($option->id)) {
            $type->options()->updateExistingPivot($option->id, [TypeOption::FIELD_SORT => $sort]);
        }else {
            $type->options()->save($option, [TypeOption::FIELD_SORT => $sort]);
        }
        
        if (!empty($option)) {
            return response()->json($option);
        }else {
            return response()->json([]);
        }
    }
    
    public function destroy($type_id, $option_id)
    {
        /** @var Type $type */
        $type = Type::query()->findOrFail($type_id);
        
        /** @var Option $option */
        $option = Option::query()->findOrFail($option_id);
        if (empty($option)) {
            return 'ok';
        }
        
        $type->options()->detach([$option->id]);
        $count = TypeOption::query()->where(TypeOption::FIELD_OPTION_ID, $option_id)->count();
        if ($count == 0) {
            $option->delete();
            
            return 'deleted';
        }
        
        return 'ok';
    }
}

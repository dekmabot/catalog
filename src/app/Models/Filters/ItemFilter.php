<?php

namespace Dekmabot\Catalog\app\Models\Filters;

use Dekmabot\Catalog\app\Models\Item;
use Illuminate\Database\Eloquent\Builder;

class ItemFilter extends Item
{
    const FILTER_TYPE_EQUAL = 1;
    const FILTER_TYPE_BETWEEN = 2;
    const FILTER_TYPE_LIKE = 3;
    
    public $sorts = [
        'rating' => [
            'field'    => 'rating',
            'name'     => 'по популярности',
            'reversed' => false,
            'selected' => true,
        ],
        'price'  => [
            'field'    => Item::FIELD_PRICE,
            'name'     => 'по цене',
            'reversed' => false,
            'selected' => false,
        ],
        'new'    => [
            'field'    => 'created_at',
            'name'     => 'по новизне',
            'reversed' => true,
            'selected' => false,
        ],
        'name'   => [
            'field'    => Item::FIELD_NAME,
            'name'     => 'по названию',
            'reversed' => false,
            'selected' => false,
        ],
    ];
    public $filters = [
        'code'   => [
            'field' => Item::FIELD_CODE,
            'type'  => self::FILTER_TYPE_LIKE,
        ],
        'name'   => [
            'field' => Item::FIELD_NAME,
            'type'  => self::FILTER_TYPE_LIKE,
        ],
        'price'  => [
            'field' => Item::FIELD_PRICE,
            'type'  => self::FILTER_TYPE_BETWEEN,
        ],
        'type'   => [
            'field' => Item::FIELD_TYPE_ID,
            'type'  => self::FILTER_TYPE_EQUAL,
        ],
        'brand'  => [
            'field' => Item::FIELD_BRAND_ID,
            'type'  => self::FILTER_TYPE_EQUAL,
        ],
        'rubric' => [
            'field' => Item::FIELD_RUBRIC_ID,
            'type'  => self::FILTER_TYPE_EQUAL,
        ],
    ];
    
    public $getParams = [];
    
    /**
     * @param Builder $query
     * @param boolean $paginate
     *
     * @return mixed
     */
    public function filter($query, $paginate = true)
    {
        $request = request();
        
        $query = $query
            ->with('cart')
            ->where(Item::FIELD_IS_ACTIVE, true);
        
        foreach ($this->filters as $filterName => $filter) {
            if ($request->has($filterName)) {
                
                $value = $request->get($filterName);
                if ($value === '') {
                    continue;
                }
                
                $this->getParams[$filterName] = $value;
                
                if (self::FILTER_TYPE_EQUAL === $filter['type']) {
                    $query->where($filter['field'], $value);
                    
                }elseif (self::FILTER_TYPE_BETWEEN === $filter['type']) {
                    $valueMin = $value['min'];
                    $valueMax = $value['max'];
                    $query->where($filter['field'], 'BETWEEN', $valueMin, $valueMax);
                    
                }elseif (self::FILTER_TYPE_LIKE === $filter['type']) {
                    $query->where($filter['field'], 'LIKE', '%' . $value . '%');
                }
            }
        }
        
        $currentSort = null;
        if ($request->has('order')) {
            $order = $request->get('order');
            foreach ($this->sorts as $sortName => $sort) {
                if ($order === $sortName) {
                    $query->orderBy(Item::TABLE . '.' . $sort['field'], $sort['reversed'] ? 'desc' : 'asc');
                    
                    $this->getParams['order'] = $order;
                    $this->sorts[$sortName]['selected'] = true;
                    $currentSort = $sortName;
                }elseif ($order === '-' . $sortName) {
                    $query->orderBy(Item::TABLE . '.' . $sort['field'], $sort['reversed'] ? 'asc' : 'desc');
                    
                    $this->getParams['order'] = $order;
                    $this->sorts[$sortName]['selected'] = true;
                    $currentSort = '-' . $sortName;
                }else {
                    $this->sorts[$sortName]['selected'] = false;
                }
            }
        }
        
        if ($paginate) {
            $query = $query->paginate(16);
            $query = $query->appends($this->getParams);
        }
        
        foreach ($this->sorts as $sortName => &$sort) {
            $value = isset($sort['selected']) && $sortName === $currentSort ? '-' . $sortName : $sortName;
            $sort['url'] = http_build_query(array_merge($this->getParams, ['order' => $value]));
        }
        
        
        return $query;
    }
    
}

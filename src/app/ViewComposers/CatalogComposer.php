<?php

namespace Dekmabot\Catalog\app\ViewComposers;

use Dekmabot\Catalog\app\Models\Cart;
use Dekmabot\Catalog\app\Models\Rubric;
use Illuminate\View\View;

class CatalogComposer
{
    static private $rubrics = null;
    static private $rubricsFooter = null;
    static private $cart = null;
    
    /* TODO: сделать через геттеры */
    
    public function __construct()
    {
    }
    
    public function compose(View $view)
    {
        $view->with('catalogRubrics', $this->getRubrics());
        $view->with('catalogRubricsFooter', $this->getRubricsFooter());
        $view->with('catalogCart', $this->getCart());
    }
    
    /**
     * @return Rubric[]
     */
    private function getRubrics()
    {
        if (null !== self::$rubrics) {
            return self::$rubrics;
        }
        
        $result = Rubric::query()
            ->where(Rubric::FIELD_IS_ACTIVE, true)
            ->where(Rubric::FIELD_PARENT_ID, null)
            ->get();
        self::$rubrics = $result;
        
        return $result;
    }
    
    /**
     * @return Rubric[]
     */
    private function getRubricsFooter()
    {
        if (null !== self::$rubricsFooter) {
            return self::$rubricsFooter;
        }
        
        $result = Rubric::query()
            ->where(Rubric::FIELD_IS_ACTIVE, true)
            ->where(Rubric::FIELD_PARENT_ID, null)
            ->where(Rubric::FIELD_IMAGE_ANNOUNCE, '!=', '')
            ->get();
        self::$rubricsFooter = $result;
        
        return $result;
    }
    
    private function getCart()
    {
        if(!request()->hasSession()){
            return null;
        }
        
        if (null !== self::$cart) {
            return self::$cart;
        }
        
        $carts = Cart::currentCart();
        
        $sum = 0;
        foreach ($carts as $item) {
            $sum += $item->count * $item->price;
        }
        
        /* TODO: убрать лишнее из ответа*/
        
        $data = [
            'count' => count($carts),
            'sum'   => $sum,
        ];
        
        self::$cart = $data;
        
        return $data;
    }
    
}
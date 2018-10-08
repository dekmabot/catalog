<?php

namespace Dekmabot\Catalog\app\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\OrderCreated;
use App\User;
use Dekmabot\Catalog\app\Models\Cart;
use Dekmabot\Catalog\app\Models\Item;
use Dekmabot\Catalog\app\Models\Order;
use Dekmabot\Catalog\app\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    const LIMIT_SUM_MIN = 1000;
    const LIMIT_COUNT_MAX = 10000;
    
    public function index()
    {
        $carts = Cart::currentCart();
        
        $sum = 0;
        foreach ($carts as $cart) {
            $sum += $cart->price * $cart->count;
        }
        
        return view('app.catalog.cart', [
            'carts'    => $carts,
            'sum'      => $sum,
            'sumLimit' => self::LIMIT_SUM_MIN,
        ]);
    }
    
    public function order(Request $request)
    {
        if ($request->isMethod('post')) {
            
            $carts = Cart::currentCart();
            if (count($carts) > 0) {
                $user = \Auth::user();
                
                $order = new Order;
                $order->fill($request->post());
                $order->user_id = $user->id;
                $order->status = Order::STATUS_NEW;
                $order->save();
                
                $countItems = 0;
                $countTotal = 0;
                $sum = 0;
                foreach ($carts as $cart) {
                    $cart->user_id = $order->user_id;
                    $cart->order_id = $order->id;
                    $cart->save();
                    
                    $countItems++;
                    $countTotal += $cart->count;
                    $sum += $cart->count * $cart->price;
                }
                
                $order->count_items = $countItems;
                $order->count_total = $countTotal;
                $order->sum = $sum;
                $order->save();
                
                // Сообщение администратору
                try{
                    Mail::to(Config::get('settings.email'))->send(new OrderCreated($order, 'createdAdmin'));
                }catch (\Exception $e){
                    dd($e);
                }
                
                // Сообщение пользователю
                try{
                    Mail::to($user)->send(new OrderCreated($order));
                }catch (\Exception $e){
                    dd($e);
                }
                
                return redirect(route(ROUTE_SITE_CATALOG_CART_THANKS));
            }
        }
        
        $lastOrder = Order::query()
            ->where(Order::FIELD_USER_ID, \Auth::id())
            ->orderBy('created_at', 'DESC')
            ->first();
        if (null === $lastOrder) {
            $lastOrder = new Order;
        }
        
        $warehouses = Warehouse::query()
            ->where(Warehouse::FIELD_IS_ACTIVE, true)
            ->orderBy(Warehouse::FIELD_POS, 'asc')
            ->get();
        
        return view('app.catalog.order', [
            'sumLimit'   => self::LIMIT_SUM_MIN,
            'lastOrder'  => $lastOrder,
            'warehouses' => $warehouses,
        ]);
    }
    
    public function thanks()
    {
        return view('app.catalog.thanks', [
        ]);
    }
    
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request)
    {
        $sessionId = $request->session()->getId();
        
        $data = $request->post('items');
        
        foreach ($data as $row) {
            
            $itemId = trim($row['itemId']);
            $count = (int)$row['count'];
            
            if ($count < 0 || $count > self::LIMIT_COUNT_MAX) {
                continue;
            }
            
            /** @var Item $item */
            $item = Item::query()->with('available')->find($itemId);
            if (null === $item || !$item->is_active) {
                continue;
            }
            
            foreach ($item->available as $warehouse) {
                $item->availableTotal += $warehouse->pivot->value;
            }
            if ($count > $item->availableTotal) {
                $count = $item->availableTotal;
            }
            
            /** @var Cart $cart */
            $cart = Cart::query()
                ->where(Cart::FIELD_ITEM_ID, $itemId)
                ->where(Cart::FIELD_SESSION, $sessionId)
                ->whereNull(Cart::FIELD_ORDER_ID)
                ->orderBy(Cart::FIELD_PRICE, 'DESC')
                ->first();
            
            if ($count < 1) {
                if (null !== $cart) {
                    $cart->delete();
                }
                
                $data = $this->fullResponse($cart, [
                    'count' => 0,
                    'sum'   => 0,
                ]);
                
                return response()->json($data);
            }
            
            if (null === $cart) {
                $cart = new Cart;
                $cart->session = $sessionId;
                $cart->item_id = $item->id;
            }
            
            $cart->price = $item->price;
            $cart->count = $count;
            
            $res = $cart->save();
            if ($res) {
                $data = $this->fullResponse($cart, [
                    'count' => $cart->count,
                    'sum'   => $cart->count * $cart->price,
                    'price' => $cart->price,
                ]);
                
                return response()->json($data);
            }
        }
        
        return response()->json([
            'count' => 0,
            'sum'   => 0,
        ]);
    }
    
    /**
     * @param Cart  $cart
     * @param array $data
     *
     * @return array
     * @throws \Throwable
     */
    private function fullResponse(Cart $cart, array $data)
    {
        // Блок html-кода для корзины в шапке сайта
        $htmlCart = view('app.catalog.inc.cart', [
            'catalogCart' => $cart->toArray(),
        ])->render();
        
        // Блок html-кода для страницы заказа
        $carts = Cart::currentCart();
        $sum = 0;
        foreach ($carts as $c) {
            $sum += $c->price * $c->count;
        }
        $htmlOrder = view('app.catalog.inc.order', [
            'sum'   => $sum,
            'count' => count($carts),
        ])->render();
        
        return array_merge($data, [
            'cart'  => $htmlCart,
            'order' => $htmlOrder,
        ]);
    }
    
    public function submit(Request $request)
    {
        dd($request->post());
    }
    
}

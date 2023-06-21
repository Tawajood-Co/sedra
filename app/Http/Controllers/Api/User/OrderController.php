<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order,OrderDetail,OrderItem,Cart,CartItem};
use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\{response,fileTrait};


class OrderController extends Controller
{
    //
    use response;
    public function store(Request $request){
        try{
            $user=Auth::guard('user_api')->user();
            DB::beginTransaction();
            $order=Order::create([
                 'user_id'                  =>$user->id,
                 'price_before_discount'    =>$request->price,
                 'price_after_discount'    =>$request->price,
                 'payment_type'             =>$request->payment_type,
              ]);

            $order_detailes=OrderDetail::create([
                'order_id'       =>$order->id,
                'phone'          =>$request->phone,
                'country_code'   =>$request->country_code,
                'note'           =>$request->note
            ]);

            $cart=Cart::where('user_id',$user->id)->first();
            $cartitems=CartItem::where('cart_id',$cart->id)->get();
            foreach($cartitems as $item){
                OrderItem::create([
                     'product_id'   => $item->product_id,
                     'quantity'     => $item->quantity,
                     'price'        =>$item->price
                ]);
                $item->delete();
            }
             $cart->total=0;
             $cart->save();

             DB::commit();
             return $this->response(true,'you create order successfuly');
        }catch(\Exception $ex){
          return $this->response(false,__('response.wrong'),null,419);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Interfaces\{CartRepositoryInterface};
use Illuminate\Support\Facades\DB;

use App\Traits\{response,fileTrait};
use App\Models\{Cart,CartItem};

class CartController extends Controller
{
    //
    use response;

    public function __construct(CartRepositoryInterface $CartRepository){
        $this->CartRepository =$CartRepository;
    }

    public function get_cart(Request $request){
        $user=Auth::guard('user_api')->user();
        $cart=Cart::with('items.product')->where('user_id',$user->id)->first();
        $data['cart']=$cart;
        return $this->response(true,'get cart successfuly',$data);
    }

    public function store_cart_item(Request $request){
        $user=Auth::guard('user_api')->user();
        $cart=Cart::where('user_id',$user->id)->first();
        try{
          DB::beginTransaction();
          $this->CartRepository->store_cart_item($user->id,$cart,$request->products);
          DB::commit();
        }catch(\Exception $ex){
          return $this->response(false,__('response.wrong'),null,419);
        }
        return $this->response(true,'product add to cart successfuly');
    }


    public function remove_item(Request $request){
        try{
            DB::beginTransaction();
            $user=Auth::guard("user_api")->user();
            $cart=Cart::where('user_id',$user->id)->first();

            $cart_item=CartItem::where(['cart_id'=>$cart->id,'product_id'=>$request->product_id])->first();
            if($cart_item==null)
            return $this->response(false,__('response.item_not_found'),null,419);

            // update cart value
            $cart->total= $cart->total-$cart_item->price;
            $cart->save();

            $cart_item->delete();
            DB::commit();


          }catch(\Exception $ex){
            return $this->response(false,__('response.wrong'),null,419);
          }
           return $this->response(true,'item remove from cart successfuly');

    }

    public function increase_item(Request $request){
      try{
        DB::beginTransaction();
        $user=Auth::guard("user_api")->user();
        $cart=Cart::where('user_id',$user->id)->first();

        $cart_item=CartItem::where(['cart_id'=>$cart->id,'product_id'=>$request->product_id])->first();
        $price=$cart_item->price/$cart_item->quantity;

        // update cart items value
        $cart_item->quantity=$cart_item->quantity+1;
        $cart_item->price=$cart_item->price+$price;
        $cart_item->save();

        // update cart value
        $cart->total= $cart->total+$price;
        $cart->save();
        DB::commit();


      }catch(\Exception $ex){
        return $this->response(false,__('response.wrong'),null,419);
      }
       return $this->response(true,'product add to cart successfuly');
    }

    public function decrease_item(Request $request){
        try{
            DB::beginTransaction();
            $user=Auth::guard("user_api")->user();
            $cart=Cart::where('user_id',$user->id)->first();

            $cart_item=CartItem::where(['cart_id'=>$cart->id,'product_id'=>$request->product_id])->first();
            if($cart_item==null)
            return $this->response(false,__('response.item_not_found'),null,419);

            $price=$cart_item->price/$cart_item->quantity;

            // update cart items value
            $cart_item->quantity=$cart_item->quantity-1;
            $cart_item->price=$cart_item->price-$price;
            $cart_item->save();

            // update cart value
            $cart->total= $cart->total-$price;
            $cart->save();
            DB::commit();


          }catch(\Exception $ex){
            return $this->response(false,__('response.wrong'),null,419);
          }
           return $this->response(true,'product remoce from cart successfuly');
    }
}

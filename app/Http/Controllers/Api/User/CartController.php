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

        
    }

    public function increase_item(){

    }

    public function decrease_item(){

    }
}

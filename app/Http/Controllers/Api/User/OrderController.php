<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order,OrderDetail,OrderItem,Cart,CartItem,Bank,BankTransfare};
use Illuminate\Support\Facades\DB;
use Auth;
use App\Traits\{response,fileTrait};


class OrderController extends Controller
{
    //
    use response,fileTrait;
    public function store(Request $request){
        try{
            $user=Auth::guard('user_api')->user();
            DB::beginTransaction();
               // if user pay by wallet
             if($request->payment_type==1){
                if($user->wallet<$request->price)
                return $this->response(false,'you have not enought mony',null,406);
                $user->wallet=$user->walle-$request->price;
                $user->save();
             }
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
                'note'           =>$request->note,
                'lat'            =>$request->lat,
                'lng'            =>$request->lng,
                'address'        =>$request->adress
            ]);

            $cart=Cart::where('user_id',$user->id)->first();
            $cartitems=CartItem::where('cart_id',$cart->id)->get();
            foreach($cartitems as $item){
                OrderItem::create([
                     'order_id'       =>$order->id,
                     'product_id'   => $item->product_id,
                     'quantity'     => $item->quantity,
                     'price'        =>$item->price
                ]);
                $item->delete();
            }
             $cart->total=0;
             $cart->save();

             DB::commit();
             return $this->response(true,'you create order successfuly order is brebared');
        }catch(\Exception $ex){
          return $this->response(false,__('response.wrong'),null,419);
        }
    }

    public function get_banks(Request $request){
       $data['banks']=Bank::get();
       return $this->response(true,'get banks successfuly',$data);
    }

    public function bank_transfare(Request $request){

        try{
            $user=Auth::guard('user_api')->user();
            $img=$this->MoveImage($request->img,'uploads/users/banktransfare');
            BankTransfare::create([
               'bank_id' =>$request->bank_id,
               'img'     =>$img,
               'user_id' =>$user->id
            ]);
            return $this->response(true,__('response.success'));

        }catch(\Exception $ex){
            return $this->response(false,__('response.wrong'),null,419);

        }
    }

    public function get_orders(Request $request){

    //    try{
        DB::beginTransaction();
        $user=Auth::guard("user_api")->user();
        $orders=Order::with(['detailes','items'])->where('user_id',$user->id)->paginate(20);
        return $orders;
        DB::commit();
        return $this->response(true,__('response.success'));
        // }catch(\Exception $ex){
        //     return $this->response(false,__('response.wrong'),null,419);
        // }

    }
}

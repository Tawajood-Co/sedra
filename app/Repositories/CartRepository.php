<?php

namespace App\Repositories;
use App\Interfaces\CartRepositoryInterface;

use App\Models\{Cart,CartItem};


class CartRepository implements CartRepositoryInterface
{

    public function store_cart($user){
        Cart::create([
            'user_id'   =>$user->id,
            'total'     =>0
         ]);
         return true;
    }


    public function store_cart_item($user_id,$cart,$products){

        $total_price=$cart->total;


        foreach ($products as $product){
            $cart_item= CartItem::where('product_id',$product['id'])->first();
            if($cart_item==null){
                CartItem::create([
                    'cart_id'           =>$cart->id,
                    'product_id'        =>$product['id'],
                    'quantity'          =>$product['quantity'],
                    'price'             =>$product['quantity']*$product['price']
                 ]);
            }else{
                $cart_item->quantity=$cart_item->quantity+$product['quantity'];
                $cart_item->price=$cart_item->price+($product['quantity']*$product['price']);
                $cart_item->save();
            }

         $total_price+=$product['quantity']*$product['price'];
        }

          $cart->total=$total_price;
          $cart->save();
          return true;
    }
}

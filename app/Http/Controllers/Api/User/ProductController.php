<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Traits\{response,fileTrait};



class ProductController extends Controller
{
    //
    use response;
    public function get_products(Request $request){

       $Products=Product::where('type',$request->type)->get();
       $data['products']=$Products;
       return $this->response(true,'get product successfuly',$data);

    }


    public function get_product(Request $request){
        $Product=Product::with('productFeatures','imgs')->find($request->product_id);
        $data['Product']=$Product;
        return $this->response(true,'get product successfuly',$data);
    }


    public function filter(Request $request){
        $data['products']= Product::with('productFeatures','imgs')
        ->where('price','<',$request->price)
        ->where('type',$request->type)->get();
        return $this->response(true,'get product successfuly',$data);
    }

}

<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{response,fileTrait};
use Illuminate\Support\Facades\DB;
use Auth;

class WalletController extends Controller
{
    //
    public function get_wallet(){
        $user=Auth::guard('user_api')->user();
        $data['wallet']=$user->wallet;
        return $this->response(true,'get user wallet success',$data);
    }


    public function charge_wallet(Request $request){

        
    }


}

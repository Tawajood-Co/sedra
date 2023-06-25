<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletLog;
use App\Traits\{response,fileTrait};
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
class WalletController extends Controller
{
    //
    use response;
    public function get_wallet(){
        $user=Auth::guard('user_api')->user();
        $data['wallet']=$user->wallet;
        return $this->response(true,'get user wallet success',$data);
    }


    public function charge_wallet(Request $request){

        $validator =Validator::make($request->all(), [
            'amount'         =>'required',
        ]);

        if ($validator->fails()) {
                return response()->json([
                    'message'=>$validator->messages()->first()
                ],403);
        }
        try{
            DB::beginTransaction();
            $user=Auth::guard('user_api')->user();
            $user->wallet=$user->wallet+$request->amount;
            $user->save();
            WalletLog::create([
              'user_id' =>$user->id,
              'amount'  =>$request->amount,
              'fort_id' =>$request->fort_id
            ]);
            DB::commit();
            return $this->response(true,__('response.success'));
        }catch(\Exception $ex){
            return $this->response(false,__('response.wrong'),null,419);
        }

    }


}

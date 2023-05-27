<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait response
{
   public function response($status,$message,$data=null,$status_code=null){
        if($status_code==null)
        $status_code=200;
        if($data!=null){
            return response()->json([
                'status'=>$status,
                'message'=>$message,
                'data'=>$data,
            ],$status_code);
        }else{
            return response()->json([
                'status'=>$status,
                'message'=>$message,
            ],$status_code);
        }
   }


    /**
     * @param $errNum
     * @param $msg
     * @return object
     */
    // public function returnError($errNum, $msg)
    // {
    //     return response()->json([
    //         'status'  => false,
    //         'message' => $msg
    //     ], $errNum);
    // }//end error response function


    /**
     * @param $key
     * @param $value
     * @param string $msg
     * @return object
     */
    // public function returnData($key, $value, $msg = false)
    // {
    //     return response()->json([
    //         'status' => true,
    //         'message' => $msg,
    //         $key => $value
    //     ],200);
    // }// end return data function

    /**
     * @param string $msg
     * @return object
     */
    // public function returnSuccessMessage($msg = false)
    // {
    //     return response()->json([
    //         'status'  => true,
    //         'message' => $msg,
    //     ], 200);
    // }// error return success function
}

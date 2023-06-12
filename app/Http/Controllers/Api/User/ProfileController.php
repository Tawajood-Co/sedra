<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\{response,fileTrait};
use Auth;
class ProfileController extends Controller
{
    //
    use response,fileTrait;
    public function index(){
       $user=Auth::guard('user_api')->user();
       $data['profile_info']=User::find(1);
       return $this->response(true,'get user success',$data);
    }
}

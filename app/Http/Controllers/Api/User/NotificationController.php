<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\NotificationRepositoryinterface;
use Auth;
use App\Traits\{response,fileTrait};

class NotificationController extends Controller
{
    //
    use response;
    private NotificationRepositoryinterface $NotificationRepository;
    public function __construct(NotificationRepositoryinterface $NotificationRepository)
    {
        $this->NotificationRepository = $NotificationRepository;
    }
    public function create_device_token(Request $request){
       $user=Auth::guard('user_api')->user();
      $this->NotificationRepository->create_device_token('user',$request->device_token,$user->id);
       return $this->response(true,'create token successfuly');
    }



}

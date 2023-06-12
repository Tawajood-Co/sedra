<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryinterface;
use App\Models\{UserDeviceToken,CompanyDeviceToken};


class NotificationRepository implements NotificationRepositoryinterface
{
   public function create_device_token($type,$token,$id){
      if($type=='user'){
        $userdevicetoken=UserDeviceToken::where('fcm_token',$token)->first();

        if($userdevicetoken==null){
            UserDeviceToken::create([
                'user_id'=>$id,
                'fcm_token'=>$token
            ]);
        }
        return true;
      }
      if($type=='company'){
        $CompanyDeviceToken=CompanyDeviceToken::where('fcm_token',$token)->first();
        if($CompanyDeviceToken==null){
            CompanyDeviceToken::create([
                'company_id'=>$id,
                'fcm_token'=>$token
            ]);
        }
        return true;
      }
   }



   public function delete_device_token($type,$token){
    if($type=='user'){
        $userdevicetoken=UserDeviceToken::where('fcm_token',$token)->first();
        if($userdevicetoken!=null){
            $userdevicetoken->delete();
        }
        return true;
      }
      if($type=='company'){
        $CompanyDeviceToken=CompanyDeviceToken::where('fcm_token',$token)->first();
        if($CompanyDeviceToken!=null){
            $CompanyDeviceToken->delete();
        }
        return true;
      }
   }

}

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



   public function sendnotification($type,$id,$title,$body,$notificationtype,$key=null,$data=null){
    $SERVER_API_KEY ='AAAAt88dQ6g:APA91bHO_XG9KUHcXk0FTBbi4KiJBTgGgQF-kVh9LdtpUx_XxjOPSdgrS62Db3Vvbsz9wqxgOF4KonhcSXKNYL6nZaGJVnILycwnmeStA3dOSPX_N5RkOOCUi4mOJ_uXVXv83rohpawf';
    if($type=='user'){
    
    }
    if($type=='company'){
        // check if user open notification setting
        $userdevicetokens=CompanyDeviceToken::where('fcm_token',$token)->pluck('fcm_token')->all();
        $data = [
            "registration_ids" => $userdevicetokens,
            "notification"=>[
                "title" => $title,
                "body" => $body
            ],
            "data"=>[

            ],

        ];
    }


    $dataString = json_encode($data);

    $headers = [
        'Authorization: key=' . $SERVER_API_KEY,
        'Content-Type: application/json',
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    $response = curl_exec($ch);
    return true;
}
}

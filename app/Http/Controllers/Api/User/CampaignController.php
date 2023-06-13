<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Campaign,UserRegiment,Regiment};
use App\Traits\{response,fileTrait};
use Auth;

class CampaignController extends Controller
{
    //
    use response;
     public function get_campaigns(Request $request){
        $campaigns=Campaign::where('status',1)
        ->when($request->country_id!=null,function($q)use($request){
           return $q->where('country_id',$request->country_id);
        })
        ->when($request->city_id!=null,function($q)use($request){
            return $q->where('city_id',$request->country_id);
         })
         ->when($request->date!=null,function($q)use($request){
            return $q->whereHas('regiments', function($q) use($request){
                return $q->whereDate('date','=',$request->date);
            });
         })
        ->get();
        $data['data']['campaigns']=$campaigns;
        return $this->response(true,'get compaigns successfuly',$data);
     }


     public function show(Request $request){
        $campaign=Campaign::with('regiments')->find($request->campaign_id);
        $data['data']['compaign']=$campaign;
        return $this->response(true,'get compaign successfuly',$data);
     }

     public function book(Request $request){
        $user=Auth::guard('user_api')->user();
        $Regiment=Regiment::find($request->regiment_id);
        $campaign=Campaign::find($request->campaign_id);

        if($campaign->available_places==0)
        return $this->response(false,'this compain is not valied',null,422);

        if($Regiment->available_places==0)
        return $this->response(false,'this Regiment is not valied',null,422);

        UserRegiment::create([
          'user_id'      =>$user->id,
          'campaign_id'  =>$request->campaign_id,
          'regiment_id'  =>$request->regiment_id,
          'price'        =>$request->price,
          'number'       =>$request->number,
          'type'         =>$request->type
        ]);

         $campaign->available_places=$campaign->available_places-$request->number;
         $campaign->save();

         $Regiment->available_places=$Regiment->available_places-$request->number;
         $Regiment->save();

        return $this->response(true,'you booked successfuly');
     }



     public function filtercampign(Request $request){

        $price=$request->price;
        $rate=$request->rate;
        //$re


     }


}

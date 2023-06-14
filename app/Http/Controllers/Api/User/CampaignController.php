<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Campaign,UserRegiment,Regiment};
use App\Traits\{response,fileTrait};
use Auth;
use Carbon\Carbon;

class CampaignController extends Controller
{
    //
    use response;
     public function get_campaigns(Request $request){
        $campaigns=Campaign::with('company')->where('status',1)
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
        $city_id=$request->city_id;

        $campaigns=Campaign::with('company')->where('status',1)->where('city_id',$city_id)

        ->when($price!=null,function($q)use($price){
            return $q->where('single_price','<',$price);
        })

        ->when($rate!=null,function($q)use ($rate){
            return $q->whereHas('company',function($q) use($rate) {
                $q->where("rate",'>=',$rate);
            });
        })

        ->get();

        $data['data']['campaigns']=$campaigns;
        return $this->response(true,'get compaigns successfuly',$data);

     }



     public function get_my_comapigns(Request $request){

        $user=Auth::guard('user_api')->user();
        $campaign_ids=UserRegiment::select('campaign_id')->where("user_id",$user->id)->pluck('campaign_id')->all();
        $campaigns=Campaign::with('company')->find($campaign_ids);

        $data['data']['campaigns']=$campaigns;

        return $this->response(true,'get my compagins success',$data);
     }


     public function show_my_campaign(Request $request){

        $currentDate = Carbon::now()->toDateString();
        $campaign_id=$request->campaign_id;

        $UserRegiment=UserRegiment::where("campaign_id",$campaign_id)->first();
        $UserRegiment->cancelation=true;

        $campaign=Campaign::with('regiments','company','campaignOfficial')->find($request->campaign_id);

        //  select regiment
        foreach($campaign->regiments as $regiment){
              $regiment->selected=false;

              if($regiment->id==$UserRegiment->id){
                    $regiment->selected=true;
                    // check if user can cancer his booking by check the avilable date of cancelation in his regiment
                    if($regiment->cancellation_date <=  $currentDate)
                    $UserRegiment->cancelation=false;
              }
        }

        $data['campaign']=$campaign;
        $data['UserRegiment']=$UserRegiment;

        return $this->response(true,'get campign successfuly',$data);
     }

}

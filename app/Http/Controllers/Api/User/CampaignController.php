<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Campaign,UserRegiment,Regiment,CompanyReview,Company};
use App\Traits\{response,fileTrait};
use Auth;
use Carbon\Carbon;
use Validator;
use Exception;


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
        $data['campaigns']=$campaigns;
        return $this->response(true,'get compaigns successfuly',$data);
     }


     public function show(Request $request){
        $campaign=Campaign::with('regiments','company')->find($request->campaign_id);
        $data['compaign']=$campaign;
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

        $campaigns=Campaign::with('company')->where('status',1)
        ->where('country_id',$request->country_id)

        ->when($city_id!=null,function($q)use($city_id){
            return $q->where('city_id',$city_id);
        })

        ->when($price!=null,function($q)use($price){
            return $q->where('single_price','<',$price);
        })

        ->when($rate!=null,function($q)use ($rate){
            return $q->whereHas('company',function($q) use($rate) {
                $q->where("rate",'>=',$rate);
            });
        })

        ->get();

        $data['campaigns']=$campaigns;
        return $this->response(true,'get compaigns successfuly',$data);

     }



     public function get_my_comapigns(Request $request){

        $user=Auth::guard('user_api')->user();
        $campaign_ids=UserRegiment::select('campaign_id')->where("user_id",$user->id)->pluck('campaign_id')->all();
        $campaigns=Campaign::with('company')->find($campaign_ids);

        $data['campaigns']=$campaigns;

        return $this->response(true,'get my compagins success',$data);
     }


     public function show_my_campaign(Request $request){
        $user=Auth::guard('user_api')->user();

        $currentDate = Carbon::now()->toDateString();
        $campaign_id=$request->campaign_id;

        $UserRegiment=UserRegiment::where("campaign_id",$campaign_id)->first();
        $UserRegiment->cancelation=true;

        $campaign=Campaign::with('regiments','company','campaignOfficial')->find($request->campaign_id);


        // check if user make review for this campaign or not
        $makereview=true;
        $CompanyReview=CompanyReview::where(['user_id'=>$user->id,'campaign_id'=>$request->campaign_id])->first();
        if($CompanyReview!=null)
        $makereview=false;

        $campaign->makereview=$makereview;

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


     public function review_company(Request $request){


        $validator =Validator::make($request->all(), [

            'rate'         =>'required',
            'review'       =>'required',
            'company_id'   =>'required',
            'campaign_id'  =>'required',

        ]);

        if ($validator->fails()) {
                return response()->json([
                    'message'=>$validator->messages()->first()
                ],403);
        }

       try {
            $user=Auth::guard('user_api')->user();

            $CompanyReview=CompanyReview::where(['user_id'=>$user->id,'campaign_id'=>$request->campaign_id])->first();
            if($CompanyReview!=null)
            return $this->response(false,'you already review this campaign',null,419);

            CompanyReview::create([
               'rate'          =>$request->rate,
               'review'        =>$request->review,
               'company_id'    =>$request->company_id,
               'user_id'       =>$user->id,
               'campaign_id'   =>$request->campaign_id
            ]);
            $company=Company::find($request->company_id);
             // number of reviews
            $CompanyReviewcount=CompanyReview::where('company_id',$request->company_id)->count();


            $total_rate=$company->total_rate+$request->rate;
            $company->total_rate=$total_rate;
            $company->save();
             // rate of company
            $rate= $total_rate/$CompanyReviewcount;

            $company->rate=$rate;
            $company->save();


            return $this->response(true,'you make review successfuly');
        }catch(\Exception $ex){
             return $this->response(false,__('response.wrong'),null,419);
        }
     }

     public function get_company_reviews(Request $request){

        $company_id=$request->company_id;

        $reviews=CompanyReview::with('user',function($q){
            return $q->select('name')->get();
        })->where('company_id',$company_id)->get();

        $data['reviews']=$reviews;

        return $this->response(true,'get reviews successfuly',$data);
     }

}

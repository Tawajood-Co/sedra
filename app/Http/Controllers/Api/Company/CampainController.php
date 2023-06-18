<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\companyapi\CompaignStore;
use App\Models\{Campaign,Regiment,CampaignTranslation,CampaignOfficial,UserRegiment};
use App\Traits\{response,fileTrait};
use Auth;

class CampainController extends Controller
{
    //
    use  fileTrait,response;
    public function store(CompaignStore $request){

       //  validation
       if(count($request->regiment_days)!==count($request->regiment_dates)||count($request->regiment_dates)!=count($request->regiment_counts))
       return $this->response(false,'regmints array count not identical',null,422);

       $personscount=0;
       foreach($request->regiment_counts as $count){
          $personscount+=(int)$count;
       }

       if($personscount>(int)$request->persons_count)
       return $this->response(false,__('response.persons_count'),null,422);
       // end validation


       $img=$this->MoveImage($request->img,'uploads/companies/campaigns');
       $company=Auth::guard('company_api')->user();

       $compaign=Campaign::create([
          'program'           =>$request->program,
          'img'               =>$img,
          'single_price'      =>$request->single_price,
          'double_price'      =>$request->double_price,
          'country_id'        =>$request->country_id,
          'city_id'           =>$request->city_id,
          'persons_count'     =>$request->persons_count,
          'available_places'  =>$request->persons_count,
          'company_id'        =>$company->id

       ]);

       CampaignTranslation::insert([
        [
            'name'        =>   $request->name_ar,
            'description' =>   $request->description_ar,
            'campaign_id' =>   $compaign->id,
            'locale'      =>   'ar'
        ],
        [
            'name'        =>   $request->name_en,
            'description' =>   $request->description_en,
            'campaign_id' =>$compaign->id,
            'locale'      =>   'en'
        ],
        ]);

        CampaignOfficial::create([
             'name'            =>$request->admin_name,
             'phone'           =>$request->admin_phone,
             'campaign_id'     =>$compaign->id,
             'country_code'      =>$request->admin_country_code,
            ]);

       foreach($request->regiment_days as $key=>$day){
            Regiment::create([
                'days_count'         =>$day,
                'campaign_id'        =>$compaign->id,
                'date'               =>$request->regiment_dates[$key],
                'persons_count'      =>$request->regiment_counts[$key],
                'available_places'   =>$request->regiment_counts[$key],
                'cancellation_date'  =>$request->cancellation_date[$key]
            ]);
       }

       return $this->response(true,'add copagin successfuly');

    }

    public function get_compaines(Request $request){
        $company=Auth::guard('company_api')->user();
        $compaines=Campaign::with('company')->where('company_id',$company->id)->get();
        $data['compaines']=$compaines;
        return $this->response(true,'get data success',$data);
    }


    public function booking_users(Request $request){
      $Regiments =  Regiment::with('booking.users')->where('campaign_id',$request->campaign_id)->get();
      $data['Regiments']=$Regiments;
      return $this->response(true,'get user booking successfuly',$data);
    }




}

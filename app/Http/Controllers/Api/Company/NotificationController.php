<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompanyDeviceToken;
use App\Interfaces\NotificationRepositoryinterface;
use App\Traits\{response,fileTrait};
use Auth;
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
        $company=Auth::guard('company_api')->user();
        $this->NotificationRepository->create_device_token('company',$request->device_token,$company->id);
        return $this->response(true,'create token successfuly');
     }


}

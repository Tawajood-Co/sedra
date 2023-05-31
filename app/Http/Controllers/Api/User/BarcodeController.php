<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarcodeTemplate;
use App\Http\Requests\barcodetemplate as barcodetemplateRequest;
use App\Traits\{response,fileTrait};


class BarcodeController extends Controller
{
    //
    use response,fileTrait;
    public function store(barcodetemplateRequest $request){
        $passport_img=$this->MoveImage($request->passport_img,'uploads/users/qrcode');
        BarcodeTemplate::create([
          'passport_img'      =>$passport_img,
          'passport'          =>$request->passport,
          'name'              =>$request->name,
          'phone'             =>$request->phone,
          'country_code'      =>$request->country_code
        ]);
        return $this->response(true,__('response.add_qrcode'));
    }
}

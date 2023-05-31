<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OmraVisa;
use App\Http\Requests\OmraVisa as OmraVisaRequest;

use App\Traits\{response,fileTrait};



class OmraVisaController extends Controller
{
    //
    use response,fileTrait;
    public function store(OmraVisaRequest $request){
    
        $personal_img=$this->MoveImage($request->personal_img ,'uploads/users/omra');
        $passport_img=$this->MoveImage($request->passport_img,'uploads/users/omra');

        OmraVisa::create([
           'personal_img' =>$personal_img,
           'passport_img' =>$passport_img,
        ]);
        return $this->response(true,'visa added succesfuly');
    }
}

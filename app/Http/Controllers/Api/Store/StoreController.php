<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommissionResource;
use App\Http\Resources\UserResource;
use App\Models\Commissions;
use App\User;
use Carbon\Carbon;
use Validator;

class StoreController extends Controller
{
    //
    public function mypayments(Request $request){
$user = $request->user();
if($user->type != '2'){
    $errorsLogin = ['key' => 'message',
    'value' => 'تأكد من العضوية'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
}


$commissions = Commissions::where('user_id',$user->id)->orderBy('id','desc')->get();
if($commissions->count() > 0){
return ApiController::respondWithSuccess(CommissionResource::collection($commissions));
}else{
    $errorsLogin = ['key' => 'message',
    'value' => 'لا يوجد مدفوعات بعد '
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
}

    }




    public function lastLogin(Request $request){
         $user = $request->user();
         $user->last_login_at = Carbon::now()->toDateTimeString();
          $user->last_login_ip =  $request->getClientIp();
          $user->save();
          return ApiController::respondWithSuccess([]); 
    }


    public function editProfile(Request $request)
    {
        $rules = [
            'logo' => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
            'name' => 'nullable',
            'description' => 'nullable',
  
       
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user = User::where('id', $request->user()->id)->where('type','2')->first();
        if($user->type == '2'){
            $updated = $user->update([
                'name' => $request->name == null ? $user->name : $request->name,
                'description' => $request->description == null ? $user->description : $request->description,
    
            ]);
            if ($request->logo) {
                $updated = $user->update([
                    'logo'          => $request->file('logo') == null ? $user->logo : UploadImageEdit($request->logo,'logo','uploads/users',$user->logo),
                    ]);
            }
        
            return $updated
                ? ApiController::respondWithSuccess(new UserResource($user))
                : ApiController::respondWithServerErrorObject();
        }else{
            $errorsLogin = ['key' => 'message',
            'value' => 'تأكد من العضوية'
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }

    }
}

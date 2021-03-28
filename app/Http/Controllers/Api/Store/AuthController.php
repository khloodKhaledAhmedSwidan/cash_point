<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Auth;
use App\Notifications\Newvisit;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
 
   //

   public function login(Request $request)
   {

       $rules = [
           'phone' => 'required',
           'password' => 'required',
           'device_token' => 'required',
           'type'         => 'required|in:1,2'
       ];

       $validator = Validator::make($request->all(), $rules);

       if ($validator->fails())
           return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

if($request->type == 1){
    if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password , 'type'=> '1'])) {

        if (Auth::user()->active == 0) {
            $errors = ['key' => 'message',
                'value' => 'عذرا ، تم إيقاف عضويتك من قبل الإدارة'
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
     //    if(Auth::user()->type != 2  ) {
     //        $errors = ['key' => 'message',
     //            'value' => 'تأكد من بياناتك'
     //        ];
     //        return ApiController::respondWithErrorArray(array($errors));
     //    }
        //save_device_token....
        $created = ApiController::createUserDeviceToken(Auth::user()->id, $request->device_token);

        $all = User::where('phone', $request->phone)->where('type','1')->first();
        $all->update(['api_token' => generateApiToken($all->id, 10)]);
        $user = User::where('phone', $request->phone)->where('type','1')->first();



        return $created
            ? ApiController::respondWithSuccess( new ClientResource($user))
            : ApiController::respondWithServerErrorArray();
    } else {
        $errors = [
            'key' => 'message',
            'value' => 'بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.',
        ];
        return ApiController::respondWithErrorNOTFoundArray(array($errors));
    }
}elseif($request->type == 2){
    if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password , 'type'=> '2'])) {

        if (Auth::user()->active == 0) {
            $errors = ['key' => 'message',
                'value' => 'عذرا ، تم إيقاف عضويتك من قبل الإدارة'
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
     //    if(Auth::user()->type != 2  ) {
     //        $errors = ['key' => 'message',
     //            'value' => 'تأكد من بياناتك'
     //        ];
     //        return ApiController::respondWithErrorArray(array($errors));
     //    }
        //save_device_token....
        $created = ApiController::createUserDeviceToken(Auth::user()->id, $request->device_token);

        $all = User::where('phone', $request->phone)->where('type','2')->first();
        $all->update(['api_token' => generateApiToken($all->id, 10)]);
        $user = User::where('phone', $request->phone)->where('type','2')->first();



        return $created
            ? ApiController::respondWithSuccess( new UserResource($user))
            : ApiController::respondWithServerErrorArray();
    } else {
        $errors = [
            'key' => 'message',
            'value' => 'بيانات الاعتماد هذه غير متطابقة مع البيانات المسجلة لدينا.',
        ];
        return ApiController::respondWithErrorNOTFoundArray(array($errors));
    }
}
 


   }


   public function forgetPassword(Request $request)
   {
       $rules = [
           'phone' => 'required|numeric',
           'type'   => 'required|in:1,2',
       ];

       $validator = Validator::make($request->all(), $rules);

       if ($validator->fails())
           return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));


           if($request->type == 1){
            $user = User::where('phone', $request->phone)->where('type','1')->first();

            if ($user) {
                $code = mt_rand(1000, 9999);
                $updated = User::where('phone', $request->phone)->where('type','1')->update([
                    'verification_code' => $code,
                ]);
                $user->notify(new Newvisit($code));
                $success = ['key' => 'message',
                    'value' => "تم ارسال الكود بنجاح"
                ];
     
                return $updated
                    ? ApiController::respondWithSuccess($success)
                    : ApiController::respondWithServerErrorObject();
     
            }
            $errorsLogin = ['key' => 'message',
                'value' => 'رقم الهاتف غير صحيح'
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
           }elseif($request->type == 2){
            $user = User::where('phone', $request->phone)->where('type','2')->first();

            if ($user) {
                $code = mt_rand(1000, 9999);
                $updated = User::where('phone', $request->phone)->where('type','2')->update([
                    'verification_code' => $code,
                ]);
                $user->notify(new Newvisit($code));
                $success = ['key' => 'message',
                    'value' => "تم ارسال الكود بنجاح"
                ];
     
                return $updated
                    ? ApiController::respondWithSuccess($success)
                    : ApiController::respondWithServerErrorObject();
     
            }
            $errorsLogin = ['key' => 'message',
                'value' => 'رقم الهاتف غير صحيح'
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
           }
  
   }

   public function confirmResetCode(Request $request)
   {

       $rules = [
           'phone' => 'required|numeric',
           'code' => 'required',
           'type'   => 'required|in:1,2',
       ];

       $validator = Validator::make($request->all(), $rules);
       if ($validator->fails())
           return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
if($request->type == 1){
    $user = User::where('phone', $request->phone)->where('verification_code', $request->code)->where('type','1')->first();
    if ($user) {
        $updated = User::where('phone', $request->phone)->where('verification_code', $request->code)->where('type','1')->update([
            'verification_code' => null
        ]);
        $success = ['key' => 'message',
            'value' => "الكود صحيح"
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    } else {

        $errorsLogin = ['key' => 'message',
            'value' => trans('messages.error_code')
        ];
        return ApiController::respondWithErrorClient(array($errorsLogin));
    }
}elseif($request->type == 2){
    $user = User::where('phone', $request->phone)->where('verification_code', $request->code)->where('type','2')->first();
    if ($user) {
        $updated = User::where('phone', $request->phone)->where('verification_code', $request->code)->where('type','2')->update([
            'verification_code' => null
        ]);
        $success = ['key' => 'message',
            'value' => "الكود صحيح"
        ];
        return $updated
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    } else {

        $errorsLogin = ['key' => 'message',
            'value' => trans('messages.error_code')
        ];
        return ApiController::respondWithErrorClient(array($errorsLogin));
    }
}
 


   }

   public function resetPassword(Request $request)
   {
       $rules = [
           'phone' => 'required',
           'password' => 'required',
           'password_confirmation' => 'required|same:password',
           'type'   => 'required|in:1,2',
       ];

       $validator = Validator::make($request->all(), $rules);

       if ($validator->fails())
           return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
if($request->type == 1){
    $user = User::where('phone', $request->phone)->where('type','1')->first();
    //        $user = User::wherePhone($request->phone)->first();
    
           if ($user)
               $updated = $user->update(['password' => Hash::make($request->password)]);
           else {
               $errorsLogin = ['key' => 'message',
                   'value' => 'هذا الرقم غير موجود'
               ];
               return ApiController::respondWithErrorClient(array($errorsLogin));
           }
    
    
           return $updated
               ? ApiController::respondWithSuccess('تم تغيير كلمة المرور بنجاح')
               : ApiController::respondWithServerErrorObject();
}elseif($request->type == 2){
    $user = User::where('phone', $request->phone)->where('type','2')->first();
    //        $user = User::wherePhone($request->phone)->first();
    
           if ($user)
               $updated = $user->update(['password' => Hash::make($request->password)]);
           else {
               $errorsLogin = ['key' => 'message',
                   'value' => 'هذا الرقم غير موجود'
               ];
               return ApiController::respondWithErrorClient(array($errorsLogin));
           }
    
    
           return $updated
               ? ApiController::respondWithSuccess('تم تغيير كلمة المرور بنجاح')
               : ApiController::respondWithServerErrorObject();
}

   }


   public function changePassword(Request $request)
   {

       $rules = [
           'current_password' => 'required',
           'new_password' => 'required',
           'password_confirmation' => 'required|same:new_password',
       ];

       $validator = Validator::make($request->all(), $rules);

       if ($validator->fails())
           return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

       $error_old_password = ['key' => 'message',
           'value' => trans('messages.error_old_password')
       ];
       if (!(Hash::check($request->current_password, $request->user()->password)))
           return ApiController::respondWithErrorNOTFoundObject(array($error_old_password));
//        if( strcmp($request->current_password, $request->new_password) == 0 )
//            return response()->json(['status' => 'error', 'code' => 404, 'message' => 'New password cant be the same as the old one.']);

       //update-password-finally ^^
       $updated = $request->user()->update(['password' => Hash::make($request->new_password)]);

       $success_password = ['key' => 'message',
           'value' => 'تم تغيير كلمة المرور بنجاح'
       ];

       return $updated
           ? ApiController::respondWithSuccess($success_password)
           : ApiController::respondWithServerErrorObject();
   }

   public function change_phone_number(Request $request)
   {

//dd($request->user());
       $rules = [
           'phone' => 'required|numeric',
           'type' => 'required|in:1,2',
          'country_id'       => 'required|exists:countries,id',
       ];

       $validator = Validator::make($request->all(), $rules);

//        dd($rules);
       if ($validator->fails())
           return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

          $phone = substr($request->phone, 0, 2) === '05' ?$result = substr($request->phone, 1)  : $result = $request->phone;

            $phone = Country::where('id',$request->country_id)->first()->code . $result;

if($request->type == 1){
    $phoneCheck = User::where('phone',$request->phone)->where('type','1')->whereNotIn('id',[$request->user()->id])->first();
            if($phoneCheck)
            {
                $errors = [
                    'key'=>'message',
                    'value'=>'رقم الهاتف مستخدم من قبل',
                ];
                return ApiController::respondWithErrorNOTFoundArray(array($errors));
            }
}elseif($request->type == 2){
    $phoneCheck = User::where('phone',$request->phone)->where('type','2')->whereNotIn('id',[$request->user()->id])->first();
            if($phoneCheck)
            {
                $errors = [
                    'key'=>'message',
                    'value'=> 'رقم الهاتف مستخدم من قبل',
                ];
                return ApiController::respondWithErrorNOTFoundArray(array($errors));
            }
}
        
       $code = mt_rand(1000, 9999);


       $jsonObj = array(
           'mobile' => '',
           'password' => '',
           'sender' => '',
           'numbers' => $phone,
           'msg' => 'كود التأكيد الخاص بك في كاش بوينت هو :' . $code,

           'msgId' => rand(1, 99999),

           'timeSend' => '0',

           'dateSend' => '0',

           'deleteKey' => '55348',
           'lang' => '3',
           'applicationType' => 68,
       );
       // دالة الإرسال JOSN
       $result = $this->sendSMS($jsonObj);
       $updated = User::where('id', $request->user()->id)->update([
           'verification_code' => $code,
       ]);

       $success = ['key' => 'message',
           'value' => 'تم ارسال الكود بنجاح.'
       ];
       return $updated
           ? ApiController::respondWithSuccess($success)
           : ApiController::respondWithServerErrorObject();

   }


   public function check_code_changeNumber(Request $request)
   {

       $rules = [
           'code' => 'required',
           'phone' => 'required|numeric',
           'country_id' =>'required|exists:countries,id',
           'type' => 'required|in:1,2',
       ];
       $validator = Validator::make($request->all(), $rules);

       if ($validator->fails())
           return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

           if($request->type == 1){
            $user = User::where('id', $request->user()->id)->where('verification_code', $request->code)->where('type','1')->first();
            if ($user) {
                $updated = $user->update([
                    'verification_code' => null,
                    'phone' => $request->phone,
                    'country_id' =>$request->country_id,
                ]);
     
                $success = ['key' => 'message',
                    'value' => 'تم تغيير الرقم بنجاح',
                ];
                return $updated
                    ? ApiController::respondWithSuccess($success)
                    : ApiController::respondWithServerErrorObject();
            } else {
     
                $errorsLogin = ['key' => 'message',
                    'value' => 'الكود الذي ادخلته غير صحيح'
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }
           }elseif($request->type == 2){
            $user = User::where('id', $request->user()->id)->where('verification_code', $request->code)->where('type','2')->first();
            if ($user) {
                $updated = $user->update([
                    'verification_code' => null,
                    'phone' => $request->phone,
                    'country_id' =>$request->country_id,
                ]);
     
                $success = ['key' => 'message',
                    'value' => 'تم تغيير الرقم بنجاح',
                ];
                return $updated
                    ? ApiController::respondWithSuccess($success)
                    : ApiController::respondWithServerErrorObject();
            } else {
     
                $errorsLogin = ['key' => 'message',
                    'value' => 'الكود الذي ادخلته غير صحيح'
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }
           }



   }



   public function getAllData(Request $request)
   {
       $user = User::find($request->user()->id);

if($user->count() > 0 && $user->type == '2'){
    return $user
        ? ApiController::respondWithSuccess(new UserResource($user))
        : ApiController::respondWithServerErrorArray();
}

if($user->count() > 0 && $user->type == '1'){
    return $user
        ? ApiController::respondWithSuccess(new ClientResource($user))
        : ApiController::respondWithServerErrorArray();
}


   }


   public function sendSMS($jsonObj)
   {
       $contextOptions['http'] = array('method' => 'POST', 'header' => 'Content-type: application/json', 'content' => json_encode($jsonObj), 'max_redirects' => 0, 'protocol_version' => 1.0, 'timeout' => 10, 'ignore_errors' => TRUE);
       $contextResouce = stream_context_create($contextOptions);
       $url = "http://www.alfa-cell.com/api/msgSend.php";
       $arrayResult = file($url, FILE_IGNORE_NEW_LINES, $contextResouce);
       $result = $arrayResult[0];

       return $result;
   }
}

<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\Member;
use App\Models\PhoneVerification;
use App\Models\Point;
use Auth;
use App\Notifications\Newvisit;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function registerMobile(Request $request)
    {
        $rules = [
            'phone' => 'required|min:10|max:15',
            'country_id'   =>'required|exists:countries,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

   

            $phone =  substr($request->phone, 0, 2) === '05' ?    $result = substr($request->phone, 1) :   $result = $request->phone;
            $phone = Country::where('id',$request->country_id)->first()->code . $result;
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


//        $ans= substr($ans,0,1);
            $created = PhoneVerification::create([
                'code' => $code,
                'phone' => $phone,
                'country_id' => $request->country_id
            ]);


            return ApiController::respondWithSuccess([]); 

    }

    public function resend_code(Request $request)
    {

        $rules = [
            'phone' => 'required|min:10|max:15',
            'country_id'   =>'required|exists:countries,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));


            $phone =  substr($request->phone, 0, 2) === '05' ?    $result = substr($request->phone, 1) :   $result = $request->phone;
            $phone = Country::where('id',$request->country_id)->first()->code . $result;
            $code = mt_rand(1000, 9999);


            $jsonObj = array(
                'mobile' => '',
                'password' => '',
                'sender' => '',
                'numbers' => $phone,
                'msg' => 'كود التأكيد الخاص بك في كاش بوينت  هو :' . $code,

                'msgId' => rand(1, 99999),

                'timeSend' => '0',

                'dateSend' => '0',

                'deleteKey' => '55348',
                'lang' => '3',
                'applicationType' => 68,
            );
            // دالة الإرسال JOSN
            $result = $this->sendSMS($jsonObj);

            $created = PhoneVerification::create([
                'code' => $code,
                'phone' => $phone,
                'country_id' =>$request->country_id,
            ]);


            return $created
                ? ApiController::respondWithSuccess('تم ارسال الكود بنجاح')
                : ApiController::respondWithServerErrorObject();

  
    }
    public function register_phone_post(Request $request)
    {

        $rules = [
            'code' => 'required',
            'phone' => 'required|min:10|max:15',
            'country_id'   =>'required|exists:countries,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));




            $phone =  substr($request->phone, 0, 2) === '05' ?    $result = substr($request->phone, 1) :   $result = $request->phone;
            $phone = Country::where('id',$request->country_id)->first()->code . $result;

            $user = PhoneVerification::where('phone', $phone)->orderBy('id', 'desc')->first();
            if ($user) {

                if ($user->code == $request->code) {
                    $successLogin = ['key' => 'message',
                        'value' => "كود التفعيل صحيح"
                    ];
                    return ApiController::respondWithSuccess($successLogin);
                } else {
                    $errorsLogin = ['key' => 'message',
                        'value' => 'الكود الذي ادخلته غير صحيح'
                    ];
                    return ApiController::respondWithErrorClient(array($errorsLogin));
                }

            } else {

                $errorsLogin = ['key' => 'message',
                'value' => 'الكود الذي ادخلته غير صحيح'
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }



    }
    public function register(Request $request)
    {

        $rules = [
            'name' => 'required|max:255',
            'phone' => 'required|numeric',
            // 'bank_id' =>'required|exists:banks,id',
            'country_id' =>'required|exists:countries,id',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            // 'bank_account' =>'required',
            'device_token' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3000|image',
             'terms_conditions' =>'required|in:1'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));


$users = User::where('type','1')->orderBy('id','desc')->first();

$check =  User::where('phone', $request->phone)
->where('type','1')
->first();
if ($check == null)
{

$mainPoint = Member::where('main','1')->first();
        $all = [];

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            // 'bank_id' =>$request->bank_id,
            'country_id' =>$request->country_id,
            // 'bank_account' =>$request->bank_account,
            'member_id' => $mainPoint != null ?$mainPoint->id:null,
            'active' => 1,
            'type' => 1,
            'membership_num'=> $users != null ? ($users->membership_num + 1 ) :1  ,
            'password' => Hash::make($request->password),
            'image' => $request->image != null ? UploadImage($request->image, 'profile', 'uploads/users') : 'default.png',

        ]);

        $user->update(['api_token' => generateApiToken($user->id, 10)]);


        //save_device_token....
        $created = ApiController::createUserDeviceToken($user->id, $request->device_token);

        return $user
            ? ApiController::respondWithSuccess(new ClientResource($user))
            : ApiController::respondWithServerErrorArray();
        }else{
            $errors = [
                'key'=>'message',
                'value'=> 'رقم الهاتف مستخدم من قبل',
            ];
            return ApiController::respondWithErrorNOTFoundArray(array($errors));
        }
    }

    public function editProfile(Request $request)
    {
        $rules = [
            'image' => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
            'name' => 'nullable',
            // 'bank_id' => 'nullable|exists:banks,id',
            // 'bank_account' => 'nullable',
       
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        $user = User::where('id', $request->user()->id)->where('type','1')->first();
        if($user->type == '1'){
            $updated = $user->update([
                'name' => $request->name == null ? $user->name : $request->name,
                // 'bank_account' => $request->bank_account == null ? $user->bank_account : $request->bank_account,
                // 'bank_id' => $request->bank_id == null ? $user->bank_id : $request->bank_id,
            ]);
            if ($request->image) {
                $updated = $user->update([
                    'image'          => $request->file('image') == null ? $user->image : UploadImageEdit($request->image,'profile','uploads/users',$user->image),
                    ]);
            }
        
            return $updated
                ? ApiController::respondWithSuccess(new ClientResource($user))
                : ApiController::respondWithServerErrorObject();
        }else{
            $errorsLogin = ['key' => 'message',
            'value' => 'تأكد من العضوية'
            ];
            return ApiController::respondWithErrorClient(array($errorsLogin));
        }

    }



    /*
    * show client data by qrCode (depend on his id  =>unique)
    */

    public function qrClientData(Request $request,$phone)
    {
        $user = User::where('phone',$phone)->where('type','1')->first();
 if($user->count() > 0 && $user->type != '1'){
    $errorsLogin = ['key' => 'message',
    'value' => 'تأكد من العضوية'
    ];
    return ApiController::respondWithErrorClient(array($errorsLogin));
 }
 
     return $user
         ? ApiController::respondWithSuccess(new ClientResource($user))
         : ApiController::respondWithServerErrorArray();
 
 
 
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

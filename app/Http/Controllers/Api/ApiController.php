<?php

namespace App\Http\Controllers\Api;

use App\About;
use App\AppAdd;
use App\ContactUs;
use App\Education;
use App\Field;
use App\Group;
use App\GroupUser;
use App\Models\Notification;
use App\Rating;
use App\SawaqUserDevice;
use App\TermsCondition;
use App\UserDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Notification as ModelsNotification;
use Validator;

class ApiController extends Controller
{




    public function getImagesPath() {

        $data['user'] = imgPath('users');
        $data['company'] = imgPath('companies');
        $data['group'] = imgPath('groups');
        $data['app_adds'] = imgPath('app_adds');

        return $this->respondWithSuccess($data);
    }



    public function getAbout(Request $request) {

        $rules = [
            'lang'   => 'required|in:ar,en'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return $this->respondWithError(validateRules($validator->errors(), $rules));

        $data = About::where('id', 1)->select($request->lang .'_content')->first();

        return $this->respondWithSuccess($data);
    }

    public function getTermsConditions(Request $request) {

        $rules = [
            'lang'   => 'required|in:ar,en'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return $this->respondWithError(validateRules($validator->errors(), $rules));

        $data = TermsCondition::where('id', 1)->select($request->lang .'_content')->first();

        return $this->respondWithSuccess($data);
    }

    public function contactUs(Request $request) {

        $rules = [
            'name'      => 'required|max:255',
            'email'     => 'required|max:194',
            'message'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return $this->respondWithError(validateRules($validator->errors(), $rules));

        $created = ContactUs::create($request->all());

        return $created
            ? $this->respondWithSuccess($created)
            : $this->respondWithServerError();
    }

    public function listNotifications(Request $request) {

        $data = Notification::Where('user_id', $request->user()->id)->orwhere('store_id',$request->user()->id)->orderBy('id','desc')->get();
        return $this->respondWithSuccess($data);
    }
    public function delete_Notifications( $id , Request $request) {

        $data = Notification::Where('id', $id)->where('user_id',$request->user()->id)->delete();
        return $data
            ? $this->respondWithSuccess([])
            :$this->respondWithServerErrorArray();
    }

    public static function createUserDeviceToken($userId, $deviceToken) {

        $created = Device::updateOrCreate(
            [
                'user_id' => $userId
            ],
            [
                'device_token' => $deviceToken,
            ]
        );

        return $created;
    }


    public static function respondWithSuccess($data) {
        http_response_code(200);
        return response()->json(['mainCode'=> 1,'code' =>  http_response_code()  , 'data' => $data, 'error' => null])->setStatusCode(200);
    }

    public static function respondWithErrorArray($errors) {
        http_response_code(422);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(422);
    }public static function respondWithErrorObject($errors) {
        http_response_code(422);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(422);
    }
    public static function respondWithErrorNOTFoundObject($errors) {
        http_response_code(404);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(404);
    }
    public static function respondWithErrorNOTFoundArray($errors) {
        http_response_code(404);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(404);
    }
    public static function respondWithErrorClient($errors) {
        http_response_code(400);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(400);
    }
    public static function respondWithErrorAuthObject($errors) {
        http_response_code(401);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(401);
    }
    public static function respondWithErrorAuthArray($errors) {
        http_response_code(401);  // set the code
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(401);
    }


    public static function respondWithServerErrorArray() {
        $errors = 'Sorry something went wrong, please try again';
        http_response_code(500);
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(500);
    }
    public static function respondWithServerErrorObject() {
        $errors = 'Sorry something went wrong, please try again';
        http_response_code(500);
        return response()->json(['mainCode'=> 0,'code' =>  http_response_code()  , 'data' => null, 'error' => $errors])->setStatusCode(500);
    }



}

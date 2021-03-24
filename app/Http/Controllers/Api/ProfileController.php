<?php

namespace App\Http\Controllers\Api;

use App\AdminEmail;
use App\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Validator;
use App\User;
use App;
use Auth;

class ProfileController extends Controller
{
    public function about_us()
    {
        $photos = App\AboutPhoto::all();
        $arr = [];

        if ($photos->count() > 0)
        {
            foreach ($photos as $photo)
            {
                array_push($arr , [
                    'id'   => $photo->id,
                    'photo' => $photo->photo == null ? null : asset('/uploads/abouts/'.$photo->photo)
                ]);
            }
        }
        $about = App\AboutUs::first();
        $all=[
            'title'=>$about->title,
            'content'=>$about->content,
            'photos' => $arr == [] ? null : $arr,
        ];


        return ApiController::respondWithSuccess($all);
    }
    public function terms_and_conditions()
    {



        $terms = App\TermsCondition::first();
        $all=[
            'title'=>$terms->title,
            'content'=>$terms->content,
        ];


        return ApiController::respondWithSuccess($all);
    }
    public function contact_us(Request $request)
    {
        $rules = [
            'title'      => 'required',
            'message'    => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));

        // create new contact using user id
        $contact = Contact::create([
            'title'    => $request->title,
            'message'  => $request->message,
            'name'     => $request->user()->name,
            'email'    => $request->user()->email,
        ]);
        $data = [
            'title'    => $request->title,
            'message'  => $request->message,
            'name'     => $request->user()->name,
            'email'    => $request->user()->email,
        ];
        $email = AdminEmail::find(1);

        Mail::to($email->email)->send(new App\Mail\Contact($data));
        $success = ['key'=>'contact_us',
            'value'=> 'تم أرسال الرساله وسيتم  مراجعتها من  قبل الأدارة',
        ];
        return $contact
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();
    }
    public function get_my_subscription(Request $request)
    {
        $user = User::find($request->user()->id);
        $success = ['key'=>'get_my_subscription',
            'value'=> $user->subscription,
        ];
        return $user
            ? ApiController::respondWithSuccess($success)
            : ApiController::respondWithServerErrorObject();

    }
    public function app_intro()
    {
        $intros = App\Intro::all();
        $all = [];
        if ($intros->count() > 0)
        {
            foreach ($intros as $intro)
            {
                array_push($all , [
                    'id'         => $intro->id,
                    'photo'      => $intro->photo == null ? null : asset('/uploads/intros/'.$intro->photo),
                    'created_at' => $intro->created_at->format('Y-m-d'),
                ]);
            }
        }
        return ApiController::respondWithSuccess($all == [] ? null : $all);
    }
}

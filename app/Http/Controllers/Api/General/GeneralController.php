<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SliderCollection;
use App\Http\Resources\UserResource;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Setting;
use App\Models\Slider;
use App\User;
use Validator;
class GeneralController extends Controller
{
    //

    // ================all countries  with code  02 , 00966 ....==================

    public function countries(Request $request){
        $countries = Country::orderBy('created_at' , 'desc')->get();

        if($countries->count() > 0)
        {
           return ApiController::respondWithSuccess(new CountryCollection($countries));        
        }
        else{
            $errors = ['key'=>'countries',
                       'value'=> 'لا يوجد دول'
            ];
            return ApiController::respondWithErrorClient(array($errors));
    }
}



//======================= get banks name =======================

public function banks(Request $request){
    $banks = Bank::orderBy('created_at' , 'desc')->get();

    if($banks->count() > 0)
    {
       return ApiController::respondWithSuccess(new BankCollection($banks));        
    }
    else{
        $errors = ['key'=>'banks',
                   'value'=> 'لا يوجد بيانات'
        ];
        return ApiController::respondWithErrorClient(array($errors));
}
}
// ====================== get all category ===============
public function categories(Request $request){
    $categories = Category::orderBy('created_at' , 'desc')->get();

    if($categories->count() > 0)
    {
       return ApiController::respondWithSuccess(new CategoryCollection($categories));        
    }
    else{
        $errors = ['key'=>'categories',
                   'value'=> 'لا يوجد بيانات'
        ];
        return ApiController::respondWithErrorClient(array($errors));
}
}
// ================== settings  data====================

public function generalData(Request $request){
    $settings = Setting::find(1);

    if($settings)
    {
       return ApiController::respondWithSuccess(new SettingResource($settings));        
    }
    else{
        $errors = ['key'=>'settings',
                   'value'=> 'لا يوجد بيانات'
        ];
        return ApiController::respondWithErrorClient(array($errors));
}
}

// ======================== slider from dashboard , general slider  =========================

public function generalSlider(Request $request){
    $sliders = Slider::where('admin_id','!=','null')->get();

    if($sliders->count() > 0)
    {
       return ApiController::respondWithSuccess(new SliderCollection($sliders));        
    }
    else{
        $errors = ['key'=>'sliders',
                   'value'=> 'لا يوجد بيانات'
        ];
        return ApiController::respondWithErrorClient(array($errors));
}
}

/*
* all stores fun.
* take lat,long to get closest stores 
* for visitors or client 
*/
 public function allStores(Request $request){
    $rules = [
        'latitude' => 'required',
        'longitude' => 'required',
        'category_id' => 'required|exists:categories,id',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails())
        return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

$user = auth('api')->user();

if($user != null && $user->type == '2'){
    $errors = ['key'=>'sliders',
    'value'=> 'تأكد من العضوية '
];
return ApiController::respondWithErrorClient(array($errors)); 
}

        $distance = Setting::find(1)->scope_of_search;
        $lat = $request->latitude;
        $lon = $request->longitude;

  

        $stores = User::selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude) ) ) ) AS distance', [$lat, $lon, $lat])
            ->having('distance', '<=', $distance)
            ->orderBy('distance')
            ->where('category_id',$request->category_id)
            ->where('type','2')
            ->get();
     if($stores->count() > 0){
        return ApiController::respondWithSuccess(UserResource::collection($stores));    
     }else{
        $errors = ['key'=>'sliders',
        'value'=> 'لا يوجد متاجر بالقرب منك'
];
return ApiController::respondWithErrorClient(array($errors)); 
     }
 }




/*
* all stores fun.
* take category_id ,get all store in this categroy
* for visitors or client 
*/
public function stores(Request $request){
    $rules = [

        'category_id' => 'required|exists:categories,id',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails())
        return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

$user = auth('api')->user();

if($user != null && $user->type == '2'){
    $errors = ['key'=>'sliders',
    'value'=> 'تأكد من العضوية '
];
return ApiController::respondWithErrorClient(array($errors)); 
}
        $stores = User::where('type','2')
            ->where('category_id',$request->category_id)
            ->orderBy('arranging','asc')
            ->get();
     if($stores->count() > 0){
        return ApiController::respondWithSuccess(UserResource::collection($stores));    
     }else{
        $errors = ['key'=>'sliders',
        'value'=> 'لا يوجد متاجر بهذا القسم'
];
return ApiController::respondWithErrorClient(array($errors)); 
     }
 }

/*
* store (information) fun.
* take store_id to get all his data
* for visitors or client 
*/
public function store(Request $request){
    $rules = [
    
        'store_id' => 'required|exists:users,id',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails())
        return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

$user = auth('api')->user();

if($user != null && $user->type == '2'){
    $errors = ['key'=>'sliders',
    'value'=> 'تأكد من العضوية '
];
return ApiController::respondWithErrorClient(array($errors)); 
}


            $store =  User::where('id',$request->store_id)
            ->where('type','2')
            ->first();
     if($store != null){
        return ApiController::respondWithSuccess(new UserResource($store));    
     }else{
        $errors = ['key'=>'sliders',
        'value'=> 'تأكد من وجود هذا المتجر'
];
return ApiController::respondWithErrorClient(array($errors)); 
     }
 }
 

 /*
 * contact us for type of user in this app 
 */

 public function contactUs(Request $request){
    $rules = [
    
        'message' => 'required|max:225:min:10',
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails())
        return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));


        $user = $request->user();
        $contact = Contact::create([
            'user_id'  =>$user->id,
            'message'  => $request->message,
        ]);


        $data = [];
        array_push($data,[
            'id' => intval($contact->id),
            'user_id'  =>intval($contact->user_id),
            'user_name'  => User::where('id',$contact->user_id)->first()->name,
            'message'   =>strval($contact->message),
        ]);
        return $contact
        ? ApiController::respondWithSuccess($data)
        : ApiController::respondWithServerErrorArray();  
 }
}
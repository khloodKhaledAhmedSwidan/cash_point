<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SliderCollection;
use App\Models\Slider;
use Validator;

class SliderController extends Controller
{
    //

    public function addSliders(Request $request){
        $rules = [
    
            'image' => 'required|array',
            'image.*' => 'mimes:jpeg,jpg,png|max:3000',

        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
$user = $request->user();
      if($user->type != 2  ) {
            $errors = ['key' => 'message',
                'value' => 'تأكد من بياناتك'
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
    foreach($request->image as $img){
        $user->sliders()->create([
            'image' => UploadImage($img,'slider','uploads/sliders'),
        ]);
    }
  

    return ApiController::respondWithSuccess(new SliderCollection($user->sliders()->get()));
    }

    public function sliders(Request $request){
      
$user = $request->user();
      if($user->type != 2  ) {
            $errors = ['key' => 'message',
                'value' => 'تأكد من بياناتك'
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }
 
$sliders = $user->sliders()->get();

    return ApiController::respondWithSuccess(new SliderCollection($sliders));
    }



    public  function editSlider(Request $request)
    {
        $rules = [
    
            'image_id' => 'required|exists:sliders,id',
            'image' => 'required|mimes:jpeg,jpg,png|max:3000',

        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
$user = $request->user();
      if($user->type != 2  ) {
            $errors = ['key' => 'message',
                'value' => 'تأكد من بياناتك'
            ];
            return ApiController::respondWithErrorArray(array($errors));
        }

$slider = Slider::where('id',$request->image_id)->first();
$oldImage = $slider->image;
$slider->update([
    'image'  => UploadImageEdit($request->image,'slider','uploads/sliders',$oldImage),
]);

return ApiController::respondWithSuccess(new SliderCollection($user->sliders()->get()));

    }


    public function deleteSlider(Request $request){
        $rules = [
    
            'image_id' => 'required|exists:sliders,id',


        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));

            $user = $request->user();
            if($user->type != 2  ) {
                  $errors = ['key' => 'message',
                      'value' => 'تأكد من بياناتك'
                  ];
                  return ApiController::respondWithErrorArray(array($errors));
              }

              $sliders = $user->sliders()->get();
              if($sliders->count() > 1){
                $slider = Slider::where('id',$request->image_id)->first();

                @unlink(public_path('/uploads/sliders/'.$slider->image));
                $slider->delete();
                $data = ['key' => 'message',
                'value' => 'تم الحذف بنجاح   '
            ];
                return ApiController::respondWithSuccess($data);

              }else{
                $errors = ['key' => 'message',
                'value' => 'لا يمكن مسح اخر صورة   '
            ];
            return ApiController::respondWithErrorArray(array($errors)); 
              }



    }
}

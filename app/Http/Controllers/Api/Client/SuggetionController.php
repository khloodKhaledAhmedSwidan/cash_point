<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Validator;

class SuggetionController extends Controller
{
    //

    /*
    * suggest Store
    */
     public function suggestStore(Request $request)
    {
        $rules = [
            'description' => 'required|string|max:225:min:10',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ApiController::respondWithErrorObject(validateRules($validator->errors(), $rules));
    
            $user = $request->user();
            if($user->type != '1'){
                $errorsLogin = ['key' => 'message',
                'value' => 'تأكد من العضوية'
                ];
                return ApiController::respondWithErrorClient(array($errorsLogin));
            }

            $suggestion = Suggestion::create([
                'description' =>$request->description,
                'user_id'    =>$user->id,
            ]);
            $data = [];
            array_push($data,[
                'id'   =>intval($suggestion->id),
                'description' =>strval($suggestion->description),
                'created_at'      => $suggestion->created_at->format('Y-m-d'),
            ]);
            return $suggestion
            ? ApiController::respondWithSuccess($data)
            : ApiController::respondWithServerErrorArray();       

} 
}

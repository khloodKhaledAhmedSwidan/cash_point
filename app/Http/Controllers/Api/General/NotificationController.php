<?php

namespace App\Http\Controllers\Api\General;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Carbon\Carbon;
use Validator;

class NotificationController extends Controller
{
    //
    public function listNotification(Request $request)
    {
//        dd($request->user()->id);
        $notifications = Notification::Where('user_id', $request->user()->id)->orwhere('store_id',$request->user()->id)->orderBy('id', 'desc')->get();
//        dd($notifications);
        if ($notifications) {
            $data = [];
            foreach ($notifications as $notification) {
                $startTime = Carbon::parse($notification->created_at);
                $endTime = Carbon::now();

                $totalDuration = $startTime->diffForHumans($endTime);
                array_push($data, [
                    'id' => intval($notification->id),
                    'user_id' => $notification->user_id != null ? intval($notification->user_id):null ,
                    'store_id' => $notification->store_id != null ? intval($notification->store_id):null ,
                    'title' => $notification->title != null ?$notification->title :null,
                    'description' => $notification->description != null ?$notification->description:null,
                    'created_at' => $notification->created_at->format('Y-m-d'),
                    'totalDuration' => $totalDuration,
                ]);
            }

            return ApiController::respondWithSuccess($data);
        } else {
            $errors = ['key' => 'error',
                'value' => 'لا يوجد اشعارات '
            ];
            return ApiController::respondWithErrorClient(array($errors));
        }
//        return $this->respondWithSuccess($data);
    }

    public function deleteNotification(Request $request)
    {

        $rules = [
            'notification_id' => 'required|exists:notifications,id',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
            return ApiController::respondWithErrorArray(validateRules($validator->errors(), $rules));
$user = $request->user();
if($user->type == '2'){
    $data = Notification::Where('id', $request->notification_id)->where('store_id', $request->user()->id)->delete();
}
elseif($user->type == '1'){
    $data = Notification::Where('id', $request->notification_id)->where('user_id', $request->user()->id)->delete();

}
        return $data
            ? ApiController::respondWithSuccess([])
            : ApiController::respondWithServerErrorArray();
    }
}

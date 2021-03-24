<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\User;

class NotificationController extends Controller
{
    //
    public function generalNotificationPage()
    {
        return view('admin.notifications.general_notification');
    }

    public function generalNotification(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "description" => "required",
        ]);
        // Create New Notification


        $users = User::where('active', 1 )->get();
        foreach ($users as $user) {
            // Notification type 1 to public
            if($user->type == '2'){
                saveNotification( $request->title,  $request->description,  null, $user->id);

            }if($user->type == '1'){
                saveNotification( $request->title,  $request->description,  $user->id, null);
            }
        }
        $devicesTokens = Device::all()->pluck('device_token')->toArray();
        if ($devicesTokens) {
 
                sendMultiNotification($request->title, $request->description, $devicesTokens);
      
      
        }
        $notification = array(
            'message' =>  'تم ارسال الاشعار لجميع مستخدمي التطبيق',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }

    public function categoryNotificationPage()
    {
        return view('admin.notifications.category_notification');

    }

    public function categoryNotification(Request $request)
    {
        $this->validate($request, [
            "category" => "required|in:1,2",
            "title" => "required",
            "description" => "required",
        ]);
        // Create New Notification


        $users = User::where([

            ['type', $request->category],
            ['active', 1]
        ])->pluck('id');
 
        foreach ($users as $user) {
            // Notification type 1 to public
            if($request->category == 2){
                saveNotification( $request->title,  $request->description,  null, $user);
            }
            if($request->category == 1){
                saveNotification( $request->title,  $request->description,  $user, null);
            }
          
        }
        $devicesTokens = Device::all()->pluck('device_token')->toArray();
        if ($devicesTokens) {

                sendMultiNotification($request->title, $request->description, $devicesTokens);
       
     
        }
        $notification = array(
            'message' =>  'تم ارسال الاشعار',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function userNotificationPage()
    {
        return view('admin.notifications.user_notification');

    }

    public function userNotification(Request $request)
    {

        $this->validate($request, [
            "user_id" => "required",
            'user_id.*'=>'exists:users,id',
            "title" => "required",
            "description" => "required",
        ]);
        // Create New Notification

        foreach ($request->user_id as $one) {
            $user = User::find($one);
            $devicesTokens = Device::where('user_id', $user->id)
                ->pluck('device_token')
                ->toArray();
            if ($devicesTokens) {
       
                    sendMultiNotification($request->title, $request->description, $devicesTokens);
            }

            if($user->type == '2'){
                saveNotification( $request->title,  $request->description,  null, $user->id);

            }if($user->type == '1'){
                saveNotification( $request->title,  $request->description,  $user->id, null);
            }
        }
        $notification = array(
            'message' =>  'تم ارسال الاشعار',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    
    }
}

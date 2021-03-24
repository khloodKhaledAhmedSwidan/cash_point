<?php

namespace App\Http\Controllers\AdminController;

use App\Admin;
use App\AdminEmail;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Illuminate\Support\Facades\Redirect;
use Image;
use Auth;
use App\Permission;

class SettingController extends Controller
{
    //
    public function index()
    {
            $settings =settings();
            return view('admin.settings.index',compact('settings'));
    }
    public function store(Request $request)
    {
//        dd($request->deposit_type);
        $this->validate($request, [
            "bank_name"  => "required|string|max:255",
            'account_number'=> 'required|numeric',
            'phone_number'=> 'required|numeric',


        ]);

        Setting::where('id',1)->first()->update($request->all());
        $notification = array(
            'message' =>  'تم حفظ البيانات بنجاح',
            'alert-type' => 'success'
        );
        return Redirect::back()->with($notification);


    }

    public function parteners()
    {
        $users = User::where('subscription' , '1')->get();
        return view('admin.parteners.index' , compact('users'));
    }

    public function edit()
    {
        $email = AdminEmail::find(1);
        return view('admin.settings.admin_email' , compact('email'));
    }
    public function update($id , Request $request)
    {
        $this->validate($request , [
            'email'   => 'required|email'
        ]);
        $email = AdminEmail::find($id);
        $email->update($request->all());

        flash('تم  تعديل  البريد  الالكتروني بنجاح')->success();
        return back();
    }



    public function changeLogo()
    {

        $logo = settings()->logo;
        return view('admin/admins/change-logo', compact('logo'));
    }

    public function LogoImage(Request $request)
    {
        $setting = Setting::find(1);
        $this->validate($request, [

            "logo" => 'required|mimes:jpeg,bmp,png,jpg,gif,ico,psd,webp,tif,tiff|max:5000',
        ]);

        if ($request->image) {
            if ($request->image->getClientOriginalExtension() == "jfif") {
                $notification = array(
                    'message' =>  'صيغه هذه الصوره غير  مدعومه',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }
        $setting->update([
            'logo' => $request->logo == null ? $setting->logo : UploadImageEdit($request->logo, 'logo', '/uploads/logo/', $setting->logo)
        ]);
        $notification = array(
            'message' =>  'تم تعديل الصورة بنجاح',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

}

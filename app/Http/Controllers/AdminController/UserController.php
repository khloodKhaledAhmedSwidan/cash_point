<?php

namespace App\Http\Controllers\AdminController;

use App\City;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

use Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('type','2')->orderBy('id','desc')->get();
        return view('admin.users.stores.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'phone'                 => 'required|unique:users',
            'name'                  => 'required|max:255',
            'country_id'            =>'required|exists:countries,id',
            'category_id' =>'required|exists:categories,id',
            'commission' => 'required|numeric',
            'point_equal_SR' => 'required|numeric',
            'description'=>'required|max:255',
            'trade_register'                 => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'logo'                 => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'password'              => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
            'file'                 =>'required|mimes:pdf|max:10000',
            'sliders'                => 'required',
            'sliders.*'                 => 'mimes:jpeg,bmp,png,jpg|max:5000',
            'latitude' => 'required',
            'longitude' =>'required',
            'active'                => 'required',
            'arranging'                  => 'nullable|numeric',
      
        ]);

$users = User::where('arranging',$request->arranging)->first();
        // $users = User::where('type','2')->orderBy('id','desc')->first();
if($users != null){
    $notification = array(
        'message' =>  'هذا الترتيب مستخدم من قبل ',
        'alert-type' => 'error'
    );
    return redirect('admin/users/stores')->with($notification);
}
        $user = User::create([
            'phone'          => $request->phone,
            'name'           => $request->name,
            'trade_register'          => $request->file('trade_register') == null ? null : UploadImage($request->file('trade_register'), 'trade_register', '/uploads/users/trades'),
            'logo'          => $request->file('logo') == null ? null : UploadImage($request->file('logo'), 'logo', '/uploads/users'),
            'file'          => $request->file('file') == null ? null : UploadImage($request->file('file'), 'file', '/uploads/users/files/'),
            'description' =>$request->description,
            'category_id' =>$request->category_id,
            'latitude' =>$request->latitude,
            'longitude' =>$request->longitude,
            'commission' =>$request->commission,
            'country_id' =>$request->country_id,
            'point_equal_SR' =>$request->point_equal_SR,
            'membership_num'=> $users != null ? ($users->membership_num + 1 ) :1 ,
            'password'       => Hash::make($request->password),
            'active'         => $request->active,
            'type' =>'2',
            'arranging' =>$request->arranging != null ?$request->arranging:null,
   
        ]);
        if($request->sliders){
            foreach($request->sliders as $slider){
                $user->sliders()->create([
                    'image' => UploadImage($slider,'slider','uploads/sliders'),
                ]);
            }
        }
    
        $notification = array(
            'message' =>  'تم الإنشاء  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/users/stores')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        return view('admin.users.stores.edit' ,compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'phone'                 => 'required|unique:users,phone,'.$id,
            'name'                  => 'required|max:255',
            'country_id'            =>'required|exists:countries,id',
            'category_id' =>'required|exists:categories,id',
            'commission' => 'required|numeric',
            'point_equal_SR' => 'required|numeric',
            'description'=>'required|max:255',
            'trade_register'                 => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'logo'                 => 'required|mimes:jpeg,bmp,png,jpg|max:5000',
            'arranging'                  => 'nullable|numeric',
     
        ]);
        $user = User::findOrFail($id);



        $checkArranging  = User::where('arranging',$request->arranging)->count();
       
        if($checkArranging >= 1 && $user->arranging !=  $request->arranging){
         $notification = array(
             'message' =>  'هذا الرقم مستخدم من قبل',
             'alert-type' => 'error'
         );
         return back()->with($notification);
        }


        $user->update([
            'phone'          => $request->phone == null ? $user->phone : $request->phone,
            'name'           => $request->name == null ? $user->name : $request->name,
            'country_id'    =>$request->country_id,
            'category_id'    =>$request->category_id,
            'trade_register'          => $request->file('trade_register') == null ? $user->trade_register : UploadImageEdit($request->trade_register,'trade_register','uploads/users/trades',$user->trade_register),
            'logo'          => $request->file('logo') == null ? $user->logo : UploadImageEdit($request->logo,'logo','uploads/users',$user->logo),
            'commission'          => $request->commission,
            'point_equal_SR'         =>$request->point_equal_SR,
            'description'   => $request->description,
            'arranging' =>$request->arranging != null ?$request->arranging:$user->arranging,
        ]);
        $notification = array(
            'message' =>  'تم التعديل  بنجاح',
            'alert-type' => 'success'
        );
        return back()->with($notification);

    }


    public function remainInfo(Request $request, $id){

    }
    public function update_pass(Request $request, $id)
    {
        //
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed',

        ]);
        $users = User::findOrfail($id);
        $users->password = Hash::make($request->password);

        $users->save();
        $notification = array(
            'message' =>  'تم التعديل  بنجاح',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        flash('تم تعديل بيانات  المستخدم  بنجاح')->success();
        $users = User::find($id);
        $users->delete();
        return back();
    }


    public function is_active(Request $request, $id)
    {

        dd($request->all());
        if ($request->ajax()) {
            $user = User::findOrfail($id);
            if ($user->active == 1) {
                $user->active = 0;
                $user->save();

            } else {
                $user->active = 1;
                $user->save();
            }

            return 'true';
        }


    }

    public function update_privacy(Request $request, $id)
    {
        //
        $this->validate($request, [
            'active' => 'required',

        ]);
        $users = User::findOrfail($id);
        $users->active = $request->active;

        $users->save();

        return redirect()->back()->with('information',app()->getLocale() == 'en'?'updated successfully': 'تم تعديل اعدادات المستخدم');
    }
}

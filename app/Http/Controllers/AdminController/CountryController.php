<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $countries = Country::orderBy('id','desc')->get();
        return view('admin.countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name'                 => 'required|max:255',
            'code'                 => 'required|numeric',
            'currency'                 => 'required|max:225',

            'image' => 'nullable|mimes:jpeg,jpg,png|max:3000|image',
        ]);

        $country = Country::create([
            'name'          => $request->name,
            'code' =>$request->code,
            'currency' =>$request->currency,
            'image'         => $request->image != null ? UploadImage($request->image,'country','uploads/countries') : null,
        ]);
        $notification = array(
            'message' =>  'تم الإنشاء  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/countries')->with($notification);
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
        //
        $country = Country::find($id);
        return view('admin.countries.edit',compact('country'));
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
        //

        $country = Country::find($id);
        $this->validate($request, [
            'name'                 => 'nullable|max:255',
            'code'                 => 'nullable|numeric',
            'currency'                 => 'nullable|max:225',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3000',
        ]);

        $country->update([
            'name' =>$request->name,
            'code' =>$request->code,
            'currency' =>$request->currency,
            'image' => $country->image != null ? ($request->image != null ?UploadImageEdit($request->image,'country','uploads/countries', $country->image):$country->image): ($request->image != null ?UploadImage($request->image,'country','uploads/countries') : null ) ,
        ]);
        $notification = array(
            'message' =>  'تم التعديل  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/countries')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $country =  Country::find($id);
        if( $country->users()->count() > 0 ){
            $notification = array(
                'message' =>  'لا يمكن حذف هذه الدولة تحتوي علي مستخدميين    ',
                'alert-type' => 'error'
            );  
             return redirect('admin/countries')->with($notification);
        }else{
            @unlink(public_path('/uploads/countries/'.$country->image));
            $country->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        
    }
}

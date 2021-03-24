<?php

namespace App\Http\Controllers\AdminController;

use App\AboutPhoto;
use App\AboutUs;
use App\Intro;
use App\PaymentValue;
use App\Setting;
use App\TermsCondition;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redirect;
use Image;
use Auth;
use App\Permission;

class PageController extends Controller
{
    //
    public function about()
    {
        $settings =AboutUs::find(1);
        $photos = AboutPhoto::all();
        return view('admin.pages.about',compact('settings' , 'photos'));
    }
    public function store_about(Request $request)
    {
        $this->validate($request, [
            "title"  => "required|string|max:255",
            'content'=> 'required|string',
            'photo'  => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
        ]);

        $about =  AboutUs::where('id',1)->first();
        $about->update($request->all());
        // create a new photos  to abouts

        if ($request->file('photo') != null)
        {
            AboutPhoto::create([
                'about_id'       => $about->id,
                'photo'          => $request->file('photo') == null ? null : UploadImage($request->file('photo'), 'photo', '/uploads/abouts'),
            ]);
        }


        return Redirect::back()->with('success', 'تم حفظ البيانات بنجاح');


    }
    public function intro()
    {

    }
    public function terms()
    {



        $settings =TermsCondition::find(1);
        return view('admin.pages.terms',compact('settings'));

//
    }
    public function store_terms(Request $request)
    {
//        dd($request->deposit_type);
        $this->validate($request, [
            "title"  => "required|string|max:255",
            'content'=> 'required|string',
        ]);

        TermsCondition::where('id',1)->first()->update($request->all());

        return Redirect::back()->with('success', 'تم حفظ البيانات بنجاح');


    }
    public function create()
    {
        $payment = PaymentValue::find(1);
        return view('admin.pages.payment'  , compact('payment'));
    }
    public function store(Request $request)
    {
        $this->validate($request , [
            'value' => 'required'
        ]);
        $payment = PaymentValue::find(1);
        $payment->update([
            'value'  => $request->value,
        ]);
        flash('تم  تعديل قيمه الأشتراك  بنجاح')->success();
        return \redirect()->back();
    }




    public function choose_place(Request $request)
    {
        $this->validate($request, [
            "user_id"  => "required",
            'place_id' => 'required',
        ]);
    }
    /**
     * @remove_about_photo
     */
    public function remove_about_photo($id)
    {
        $deleted = AboutPhoto::where('id', $id)->delete();
        if ($deleted) {
            $v = '{"message":"done"}';
            return response()->json($v);
        }
    }
    /**
     * @remove_intro_photo
     */
    public function remove_intro_photo($id)
    {
        $deleted = Intro::where('id', $id)->delete();
        if ($deleted) {
            $v = '{"message":"done"}';
            return response()->json($v);
        }
    }
}

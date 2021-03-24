<?php

namespace App\Http\Controllers\AdminController;

use App\AboutPhoto;
use App\AboutUs;
use App\Intro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class IntroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check = Intro::all();
        if ($check->count() == 0)
        {
            flash('يجب أن يكون  الأنترو يوجد به صوره واحده ع الاقل ')->error();
        }
         $photos = Intro::all();
        return view('admin.pages.intros',compact( 'photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'photo'  => 'nullable|mimes:jpeg,bmp,png,jpg|max:5000',
        ]);

        $check = Intro::all();
        if ($check->count() == 0)
        {
            flash('يجب أن يكون  الأنترو يوجد به صوره واحده ع الاقل ')->error();
        }
        if ($request->file('photo') != null)
        {
            Intro::create([
                'photo'          => $request->file('photo') == null ? null : UploadImage($request->file('photo'), 'photo', '/uploads/intros'),
            ]);
        }
        return Redirect::back()->with('success', 'تم حفظ البيانات بنجاح');

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
    }
}

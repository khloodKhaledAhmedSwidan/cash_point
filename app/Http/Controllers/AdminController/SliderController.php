<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sliders = Slider::orderBy('id','desc')->get();
        return view('admin.sliders.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.sliders.create');
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
            'link'                 => 'nullable|max:255',
            'user_id'                 => 'nullable|exists:users,id',
            'image' => 'required|mimes:jpeg,jpg,png|max:3000|image',
        ]);
if($request->user_id != null && $request->link != null){
    $notification = array(
        'message' =>  ' اضف لينك او متجر لا يمكن اضافه الاثنان معا',
        'alert-type' => 'error'
    );
    return redirect('admin/sliders')->with($notification);
}
        $slider = Slider::create([
            'user_id'=> $request->user_id,
            'admin_id' => auth('admin')->user()->id,
            'link'          => $request->link,
            'image'         => UploadImage($request->image,'slider','uploads/sliders'),
        ]);
        $notification = array(
            'message' =>  'تم الإنشاء  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/sliders')->with($notification);
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
        $slider = Slider::find($id);
        return view('admin.sliders.edit',compact('slider'));
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
        $this->validate($request, [
            'link'                 => 'nullable|max:255',
            'user_id'                 => 'nullable|exists:users,id',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3000|image',
        ]);
        $slider= Slider::find($id);
        $oldImage = $slider->image;
        if($request->user_id != null && $request->link != null){
            $notification = array(
                'message' =>  ' اضف لينك او متجر لا يمكن اضافه الاثنان معا',
                'alert-type' => 'error'
            );       
                
            return redirect('admin/sliders')->with($notification);
        }
        $slider->update([
            'user_id'=> $request->user_id,
            'admin_id' => auth('admin')->user()->id,
            'link'          => $request->link,
            'image' =>  $request->image != null ?UploadImageEdit($request->image,'slider','uploads/sliders',$oldImage):$slider->image,
        ]);
        $notification = array(
            'message' =>  'تم التعديل  بنجاح',
            'alert-type' => 'success'
        );
               
        return redirect('admin/sliders')->with($notification);
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
        $slider =  Slider::find($id);

            @unlink(public_path('/uploads/sliders/'.$slider->image));
            $slider->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
   
        
    }
}

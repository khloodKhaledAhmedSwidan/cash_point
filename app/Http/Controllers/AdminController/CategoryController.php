<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::orderBy('id','desc')->get();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
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
            'image' => 'required|mimes:jpeg,jpg,png|max:3000|image',
        ]);

        $category = Category::create([
            'name'          => $request->name,
            'image'         => UploadImage($request->image,'category','uploads/categories'),
        ]);

        $notification = array(
            'message' =>  'تم إنشاء القسم بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/categories')->with($notification);
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
        $category = Category::find($id);
        return view('admin.categories.edit',compact('category'));
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

        $category = Category::find($id);
        $this->validate($request, [
            'name'                 => 'nullable|max:255',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:3000|image',
        ]);
        $oldImage = $category->image;
        $category->update([
            'name' =>$request->name,
            'image' =>  $request->image != null ?UploadImageEdit($request->image,'category','uploads/categories',$oldImage):$category->image,
        ]);

        $notification = array(
            'message' =>  'تم التعديل  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/categories')->with($notification);
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
        $category =  Category::find($id);
        if($category->users()->count() > 0 ){
            $notification = array(
                'message' =>  'لا يمكن حذف هذا القسم يحتوي علي متاجر ',
                'alert-type' => 'error'
            );
            return redirect('admin/categories')->with($notification);
        }else{
            @unlink(public_path('/uploads/categories/'.$category->image));
            $category->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        
    }
}

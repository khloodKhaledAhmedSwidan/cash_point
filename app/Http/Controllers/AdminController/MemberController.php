<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $members = Member::orderBy('type','asc')->get();
        return view('admin.members.index',compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.members.create');
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
            'title'                 => 'required|max:255',
            'point'                 => 'required|numeric',
            'main'                 => 'required',
            'type'              => 'required|numeric',
        ]);
        
$members = Member::where('main','1')->count();

if($members >= 1 && $request->main != '1'){
$checkType  = Member::where('type',$request->type)->first(); 

if($checkType){
    $notification = array(
        'message' =>  'هذا الرقم مستخدم من قبل',
        'alert-type' => 'error'
    );
    return back()->with($notification);
}
    $member = Member::create([
        'title'          => $request->title,
        'point' =>$request->point,
        'main' =>$request->main,
        'type' =>$request->type,
    ]);
    $notification = array(
        'message' =>  'تم الإنشاء  بنجاح',
        'alert-type' => 'success'
    );
    return redirect('admin/members')->with($notification);
}else{
    $notification = array(
        'message' =>  'لا يمكن انشاء اكتر من عضوية اساسية',
        'alert-type' => 'error'
    );
    return back()->with($notification);
}

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
        $member = Member::find($id);
        return view('admin.members.edit',compact('member'));
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

        $member = Member::find($id);
        $this->validate($request, [
            'title'                 => 'nullable|max:255',
            'point'                 => 'nullable|numeric',
            'type'              => 'nullable|numeric',
 
        ]);
        $members = Member::where('main','1')->count();
        if( ($members >= 1 && $request->main != '1')  || $member->main == '1'){
           $checkType  = Member::where('type',$request->type)->count();
       
           if($checkType >= 1 && $member->type !=  $request->type){
            $notification = array(
                'message' =>  'هذا الرقم مستخدم من قبل',
                'alert-type' => 'error'
            );
            return back()->with($notification);
           }
            $member->update([
                'title' =>$request->title,
                'point' =>$request->point,
                'main' =>$request->main,
                'type' =>$request->type,
            ]);
            $notification = array(
                'message' =>  'تم التعديل  بنجاح',
                'alert-type' => 'success'
            );
            return redirect('admin/members')->with($notification);
        }else{
            $notification = array(
                'message' =>  'لا يمكن انشاء اكتر من عضوية اساسية',
                'alert-type' => 'error'
            );
            return back()->with($notification);   
        }
  
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
        $member =  Member::find($id);
        if( $member->users()->count() > 0 ){
            $notification = array(
                'message' =>  'لا يمكن حذف هذه العضوية تحتوي علي مستخدميين    ',
                'alert-type' => 'error'
            );  
             return redirect('admin/members')->with($notification);
        }else{
  
            $member->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        
    }
}

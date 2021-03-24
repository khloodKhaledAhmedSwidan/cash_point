<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bank;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banks = Bank::orderBy('id','desc')->get();
        return view('admin.banks.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.banks.create');
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
        ]);

        $bank = Bank::create([
            'name'          => $request->name,
        ]);
        $notification = array(
            'message' =>  'تم الإنشاء  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/banks')->with($notification);
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
        $bank = Bank::find($id);
        return view('admin.banks.edit',compact('bank'));
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

        $bank = Bank::find($id);
        $bank->update([
            'name' =>$request->name,
        ]);
        $notification = array(
            'message' =>  'تم التعديل  بنجاح',
            'alert-type' => 'success'
        );
        return redirect('admin/banks')->with($notification);
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
        $bank = Bank::find($id);
        if($bank->users()->count() > 0){
            flash(app()->getLocale() == 'en'?'created successfully':'تم إنشاء الخدمة بنجاح')->success();
            $notification = array(
                'message' =>  'لا يمكن حذف هذا البنك يحتوي علي مستخدميين    ',
                'alert-type' => 'error'
            );
            return redirect('admin/banks')->with($notification);
        }else{
            $bank->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        
    }
}

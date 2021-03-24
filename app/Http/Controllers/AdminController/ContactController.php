<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $contacts = Contact::orderBy('id','desc')->get();
        return view('admin.contacts.index',compact('contacts'));
    }
    public function destroy($id)
    {
        //
        $contact =  Contact::find($id);


            $contact->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
   
        
    }
}

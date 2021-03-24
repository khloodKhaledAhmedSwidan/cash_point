<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Suggestion;

class SuggestionController extends Controller
{
    public function index()
    {
        //
        $suggestions= Suggestion::orderBy('id','desc')->get();
        return view('admin.suggestions.index',compact('suggestions'));
    }
    public function destroy($id)
    {
        //
        $suggestion =  Suggestion::find($id);


            $suggestion->delete();
            $notification = array(
                'message' =>  'تم الحذف  بنجاح',
                'alert-type' => 'success'
            );
            return back()->with($notification);
   
        
    }
}

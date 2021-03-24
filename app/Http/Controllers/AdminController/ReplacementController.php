<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Point;

class ReplacementController extends Controller
{
    //
    public function comfirmReplacement(){
        $points =Point::where('type','0')->where('status','3')->orderBy('id','desc')->get();
        return view('admin.replacePoints.bank_replace_point',compact('points'));
    }



    public function uncomfirmReplacement(){
        $points =Point::where('type','0')->where('status','2')->orderBy('id','desc')->get();
        return view('admin.replacePoints.Uncertain_bank_replace_point',compact('points'));
    }
    public function is_confirm(Request $request, $id)
    {

        if ($request->ajax()) {
            $point = Point::findOrfail($id);
            if ($point->active == '3') {
                $user->active = 0;
                $user->save();

            } else {
                $user->active = 1;
                $user->save();
            }

            return 'true';
        }


    }
}

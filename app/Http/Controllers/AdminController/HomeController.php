<?php

namespace App\Http\Controllers\AdminController;

use App\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->count();
        $admins = DB::table('admins')->count();

        return view('admin.home' , compact('users','admins'));
    }
    public function get_regions($id)
    {
        $regions = City::where('parent_id',$id)->select('id','name')->get();
        $data['regions']= $regions;
        return json_encode($data);
    }
}

<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Contact;
use App\User;
use App\Notifications\replay;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('id' , 'desc')->get();
        return view('admin.contacts.index' , compact('contacts'));
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
    public function reply(Request $request)
    {
        $user = User::whereEmail($request->receiver_email)->first();
        $user->notify (new replay($request->msg_body));
        $contact = Contact::find($request->id);
        $contact->update([
            'reply' => $request->msg_body
        ]);
        $v = '{"message":"done"}';
        return response()->json($v);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactU = Contact::findOrFail($id);
        return view('admin.contacts.show' , compact('contactU'));
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
        $contact = Contact::findOrFail($id);
        $contact->delete();
        flash('تم المسح  بنجاح')->success();
        return redirect()->route('Contact');
    }
}

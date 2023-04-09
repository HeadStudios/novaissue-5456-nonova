<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Hydraulics\SyncMan;

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $email = $request->input('email');

    $data = $request->all();

    return Contact::updateOrCreateContact($data);

    /*

    $contact = Contact::where('email', $email)->first();

    if ($contact) {
        // Update existing contact
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        if ($request->has('website')) {
            $contact->website = $request->input('website');
        }
        $contact->save();
    } else {
        // Create new contact
        $contact = new Contact;
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        if ($request->has('website')) {
            $contact->website = $request->input('website');
        }
        $contact->save();
    }

    return response()->json($contact);
    */
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Unsubscribed 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eunsubscribe(Request $request, $email)
    {
        $queryKey = env('QUERY_KEY');
    if (!$request->has('key') || $request->input('key') !== $queryKey) {
        abort(403, 'Unauthorized');
    }
        app()->make('SyncMan')->eunsubscribe($email);
        

        
    }

    public function smsunsubscribe($email)
    {
        app()->make('SyncMan')->smsunsubscribe($email);
        Contact::where('email', $email)
        ->update(['unsubscribed' => 1]);

        
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

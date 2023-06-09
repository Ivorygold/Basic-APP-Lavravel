<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    public function Contact(){
        return view('frontend.contact');

}//end method

    public function StoreMessage(Request $request) {
        //validate the fills
        $request->validate([
            'name' =>' Required',
            'email' =>' Required',
            'subject' =>' Required',
            'phone' =>' Required',
            'message' =>' Required',
        ],[
                                             //to infuse a custom message
       'name.Required'=>' Name is Required',  
       'email.Required'=>' Email is Required',    
      'subject.Required'=>' Subject is Required',   
      'phone.Required'=>' phone is Required',
      'message.Required'=>'message is Required',                                      

        ]);
    //because is a post and form method, we will insert to DB.
    Contact::insert([
 
        'name'=> $request->name,
        'email'=> $request->email,
        'subject'=> $request->subject,
        'phone'=> $request->phone,
        'message'=> $request->message,
        'created_at' => Carbon::now(),

    ]);
    $notification = array(
        'message' => 'Message Sent Successfully',
        'alert-type' => 'success'
      );
      return redirect()->back()->with($notification);



}//end method

}

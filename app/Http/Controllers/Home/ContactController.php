<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    //
    public function Contact(){
        return view('frontend.contact');
    }
    public function StoreMessage(Request $request){
        $contact = new Contact();
        $contact->name = $request['name'];
        $contact->email = $request['email'];
        $contact->subject = $request['subject'];
        $contact->phone = $request['phone'];
        $contact->message = $request['message'];
        $contact->created_at = Carbon::now();
        $contact->save();
        $notification = array(
            'message' => 'Message Inserted  Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }
    public function ContactMessage(){
        $contacts = Contact::query()->latest()->get();
        return view('admin.contact.allcontact',compact('contacts'));
    }

    public function EditContactMessage(string $id){
        $contact = Contact::query()->findOrFail($id);
        return view('admin.contact.edit_contact',compact('contact'));
    }

    public function UpdateContactMessage(Request $request, string $id){


        $contact = Contact::query()->find($id);
        $contact->name = $request['name'];
        $contact->email = $request['email'];
        $contact->subject = $request['subject'];
        $contact->phone = $request['phone'];
        $contact->message = $request['message'];
        $contact->save();

        $notification = array(
            'message' => 'Message Updated Successfully',
            'alert-type' => 'success',
        );

        return to_route('contact.message')->with($notification);
    }
    public function DestroyContactMessage(string $id){
        $notification = array(
            'message' => 'Message Deleted  Successfully',
            'alert-type' => 'success',
        );
//        DB::table('multi_images')->where('id', $id)->delete();

        Contact::query()->findOrFail($id)->delete();

        return to_route('contact.message')->with($notification);


    }
}

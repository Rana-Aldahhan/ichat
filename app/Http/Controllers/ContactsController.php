<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        $user=auth()->user();
        $sentContacts=$user->sentContacts;
        $receivedContacts=$user->receivedContacts;
        $contacts=$sentContacts != null ? $sentContacts->union($receivedContacts)->flatten(): $receivedContacts;
        return view('contacts',['contacts'=>$contacts]);
    }
    public function addContact(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if($user!=null)
        {
            auth()->user()->sentContacts()->save($user);
        }
        else {
            redirect('/contacts')->with('error','There is no user with such email on I chat :( !');
        }
        return redirect('/contacts');
    }
}

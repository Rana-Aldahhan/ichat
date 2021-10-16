<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
   public function update(Request $request){

       $user=auth()->user();
       //validation
       $this->validate($request,[
            'profile'=>'nullable|image|max:1999',
            'about'=>'string'
       ]);
       //store image
       if($request->hasFile('profile')){
            if($user->profile != 'default.jpg')
                unlink(storage_path('app/public/profiles/'.$user->profile));
            // Get filename with the extension
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('profile')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('profile')->storeAs('public/profiles', $fileNameToStore);
            $user->profile=$fileNameToStore;
    } 
    $user->about=$request->about;
    $user->save();
    return redirect('/home');
       

   }
}

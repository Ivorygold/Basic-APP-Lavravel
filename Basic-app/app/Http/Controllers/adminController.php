<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logged out Successfully',
            'alert-type' => 'success'
          );
    

        return redirect('/login')->with($notification);
    }
    //end Method

    public function Profile() {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view ('admin.admin_profile_view', compact('adminData'));

    }
     //end Method

     public function EdithProfile() {
        $id = Auth::user()->id;
        $editData = User::find($id);
        return view ('admin.admin_profile_edit', compact('editData'));

     }
      //end Method

      public function StoreProfile(request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        //use a condition in checking for and storing the images in the data base.
        if ($request->file('profile_image')){
            $file = $request->file('profile_image');

            //get time stamp client Name and store in the DB
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['profile_image'] = $filename;
      }  
      $data ->save();

      $notification = array(
        'message' => 'Profile Updated Successfully',
        'alert-type' => 'success'
      );

      return redirect()->route('admin.profile')->with($notification);
    }   //end Method

    public function ChangePassword() {

        return view('admin.admin_change_password');

    } //end Method

    public function UpdatePassword(request $request){

        $validateData = $request->validate([
            'oldpassword' => 'required ',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',
        ]);

        $hashedPassword = Auth::user()->password;
        if(Hash::check($request->oldpassword,$hashedPassword)) {
         $users = User::find(Auth::id());
         $users->password = bcrypt($request->newpassword);
         $users->save();

         session()->flash('message','Password Updated Successfully');
         return redirect()->back();
        } else {

            session()->flash('message','Old Password did not Match');
         return redirect()->back();

        }
    }
    //end Method
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notification =  array(
            'message' => 'User logged out successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }
    public function profile(){
        $id = auth()->user()->id;
        $adminData = user::find($id);
        return view('admin.admin_profile_view',compact('adminData'));
    }
    public function EditProfile(){
        $id = auth()->user()->id;
        $editData = user::find($id);
        return view('admin.admin_profile_edit',compact('editData'));
    }
    public function StoreProfile(Request $request){
        $id = auth()->user()->id;
        $user = User::query()->find($id);
        $user->name = $request['name'];
        $user->username = $request['username'];
        $user->email = $request['email'];
        if ($request->file('profile_image')){
            $file = $request->file('profile_image');
            @unlink(public_path('upload/admin_images/'.$user->profile_image));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $user->profile_image = $filename;
        }
        $user->save();
        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        );
        return to_route('admin.profile')->with($notification);
    }
    public function ChangePassword(){

        return view('admin.admin_change_password');
    }
    public function UpdatePassword(Request $request){
        $id = auth()->user()->id;
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required|same:newpassword',
        ]);
        $hashedPassword = Auth::user()->password;
        if ( Hash::check($request['oldpassword'],$hashedPassword)){
            $users = User::query()->find($id);
            $users->password = bcrypt($request['newpassword']);
            $users->save();
            session()->flash('message', 'Password Updated Successfully');
            return redirect()->back();
        }
        else{
            session()->flash('message', 'Old Password is not match');
        }



    }
}

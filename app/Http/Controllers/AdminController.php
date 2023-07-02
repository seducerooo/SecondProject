<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
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
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $user->profile_image = $filename;
        }
        $user->save();
        return to_route('admin.profile');
    }
}

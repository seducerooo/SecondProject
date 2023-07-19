<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    //
    public function FooterSetup(){
        $allfooter = Footer::query()->find(1);
        return view('admin.footer.footer_all',compact('allfooter'));
    }
    public function UpdateFooter(string $id, Request $request){
        $footer_id = $request['id'];


            Footer::query()->find($id)->update(
                [
                    'number' => $request->number,
                    'short_description' => $request->short_description,
                    'address' => $request->address,
                    'email' => $request->email,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'copyright' => $request->copyright

                ]
            );

            return redirect('/');




    }
}

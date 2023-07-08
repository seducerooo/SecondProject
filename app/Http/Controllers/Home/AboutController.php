<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Image;

class AboutController extends Controller
{
    //
    public function AboutPage(){
        $aboutpage =  About::query()->find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));
    }
    public function UpdateAbout(Request $request){
        $about_id = $request['id'];
        if ($request->file('about_image')){
            $image = $request->file('about_image');

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(523,625)->save('upload/home_about/'.$name_gen);

            $save_url = 'upload/about_image'.$name_gen;

            $about = About::query()->find($about_id);
            $about->title = $request['title'];
            $about->short_title = $request['short_title'];
            $about->short_description = $request['short_description'];
            $about->long_description = $request['long_description'];
            $about->about_image = $save_url;
            $about->save();
            $notification = array(
                'message' => 'About Page Updated With Image Successfully',
                'alert-type' => 'success',
            );

            return to_route('about.page')->with($notification);
        }
        else{

            $about = About::query()->find($about_id);
            $about->title = $request['title'];
            $about->short_title = $request['short_title'];
            $about->short_description = $request['short_description'];
            $about->long_description = $request['long_description'];
            $about->save();
            $notification = array(
                'message' => 'About Page Updated Without Image Successfully',
                'alert-type' => 'success',
            );

            return to_route('about.page')->with($notification);

        }
    }
}

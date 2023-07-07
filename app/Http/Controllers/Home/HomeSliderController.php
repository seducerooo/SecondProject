<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\HomeSlide;
use Illuminate\Http\Request;
use Image;


class HomeSliderController extends Controller
{
    //
    public function HomeSlider(){
        $homeslide = HomeSlide::query()->find(1);
        return view('admin.home_slide.home_slide_all',compact('homeslide'));
    }
    public function UpdateSlider(Request $request){
        $slide_id = $request['id'];
        if ($request->file('home_slide')){
            $image = $request->file('home_slide');

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(636,852)->save('upload/home_slide/'.$name_gen);

            $save_url = 'upload/home_slide'.$name_gen;

            $slide = HomeSlide::query()->find($slide_id);
            $slide->title = $request['title'];
            $slide->short_title = $request['short_title'];
            $slide->home_slide = $save_url;
            $slide->video_url = $request['video_url'];
            $slide->save();
            $notification = array(
                'message' => 'Home Slide Updated With Image Successfully',
                'alert-type' => 'success',
            );

            return to_route('home.slide')->with($notification);
        }
        else{

            $slide = HomeSlide::query()->find($slide_id);
            $slide->title = $request['title'];
            $slide->short_title = $request['short_title'];
            $slide->video_url = $request['video_url'];
            $slide->save();
            $notification = array(
                'message' => 'Home Slide Updated Without Image Successfully',
                'alert-type' => 'success',
            );

            return to_route('home.slide')->with($notification);

        }


    }
}

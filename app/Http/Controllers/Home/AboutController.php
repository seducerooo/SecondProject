<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
    public function HomeAbout(){
        $aboutpage =  About::query()->find(1);
        return view('frontend.about_page',compact('aboutpage'));
    }

    public function AboutMultiImage(){
        $multimage = MultiImage::query()->find(1);
        return view('admin.about_page.multimage',compact('multimage'));
    }
    public function StoreMultiImage(Request $request){
        $image = $request->file('multi_image');
        foreach ($image as $multi_image) {
            $name_gen = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();

            Image::make($multi_image)->resize(220, 220)->save('upload/multi/' . $name_gen);

            $save_url = 'upload/multi/' . $name_gen;

            MultiImage::query()->insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now()
            ]);
            }
            $notification = array(
                'message' => 'Multi Image Inserted  Successfully',
                'alert-type' => 'success',
            );
            return to_route('about.multi.image')->with($notification);




    }

    public function AllMultiImage(){
        $allMultiImage = MultiImage::query()->get()->all();
        return view('admin.about_page.all_multiimage',compact('allMultiImage'));
    }

    public function EditMultiImage($id){
        $MultiImage = MultiImage::query()->find($id);
        return view('admin.about_page.edit_multi_image',compact('MultiImage'));
    }
    public function UpdateMultiImage(Request $request){
        $image = $request->file('multi_image');

            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(220, 220)->save('upload/multi/' . $name_gen);

            $save_url = 'upload/multi/' . $name_gen;

            $UpdateMultiImage = new MultiImage();
            $UpdateMultiImage->multi_image = $save_url;
            $UpdateMultiImage->updated_at = $request['updated_at'];
            $UpdateMultiImage->save();

        $notification = array(
            'message' => ' Image Updated  Successfully',
            'alert-type' => 'success',
        );
        return to_route('all.multi.image')->with($notification);
    }
    public function DestroyMultiImage(string $id){
        $notification = array(
            'message' => 'Image Deleted  Successfully',
            'alert-type' => 'success',
        );
//        DB::table('multi_images')->where('id', $id)->delete();
        $multi = MultiImage::query()->find($id);
        $img = $multi->multi_image;
        unlink($img);
        MultiImage::query()->findOrFail($id)->delete();

        return to_route('all.multi.image')->with($notification);

    }
}

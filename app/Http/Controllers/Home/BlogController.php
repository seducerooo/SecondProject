<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class BlogController extends Controller
{
    //
    public function AllBlog(){
        $blog = Blog::query()->latest()->get();
        return view('admin.blogs.blogs_all',compact('blog'));
    }
    public function AddBlog(){
        $categories = BlogCategory::query()->orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_add',compact('categories'));
    }

    public function StoreBlog(Request $request){

        $request->validate([
            'blog_title' => 'required',
            'blog_tags' => 'required',
            'blog_description' => 'required'
        ],
            [
                'blog_title.required' => 'Blog Title is required',
                'blog_tags.required' => 'Blog tags is required',
                'blog_description.required' => 'Blog description is required'
            ]
        );


        $image = $request->file('blog_image');

        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(430, 327)->save('upload/blog/' . $name_gen);

        $save_url = 'upload/blog/' . $name_gen;

        Blog::query()->insert([
            'blog_category_id' => $request['blog_category_id'],
            'blog_title' => $request['blog_title'],
            'blog_image' => $save_url,
            'blog_tags' => $request['blog_tags'],
            'blog_description' => $request['blog_description'],
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'blog Inserted  Successfully',
            'alert-type' => 'success',
        );
        return to_route('all.blog')->with($notification);




    }
    public function EditBlog($id){
        $blog = Blog::query()->find($id);
        $categories = BlogCategory::query()->orderBy('blog_category','ASC')->get();
        return view('admin.blogs.blogs_edit',['blog' => $blog,'categories' => $categories ]);
    }

    public function UpdateBlog(Request $request,string $id){
        $blog_id = $request['id'];
        if ($request->file('blog_image')){
            $image = $request->file('blog_image');

            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(636,852)->save('upload/blog/'.$name_gen);

            $save_url = 'upload/blog/'.$name_gen;

            $blog = Blog::query()->find($blog_id);
            $blog->blog_category_id = $request['blog_category_id'];
            $blog->blog_title = $request['blog_title'];
            $blog->blog_image = $save_url;
            $blog->blog_tags = $request['blog_tags'];
            $blog->blog_description = $request['blog_description'];
            $blog->save();
            $notification = array(
                'message' => 'Blog Updated With Image Successfully',
                'alert-type' => 'success',
            );

            return to_route('all.blog')->with($notification);
        }
        else{

            $blog = Blog::query()->find($blog_id);
            $blog->blog_category_id = $request['blog_category_id'];
            $blog->blog_title = $request['blog_title'];
            $blog->blog_tags = $request['blog_tags'];
            $blog->blog_description = $request['blog_description'];
            $blog->save();
            $notification = array(
                'message' => 'Blog Updated Without Image Successfully',
                'alert-type' => 'success',
            );

            return to_route('all.blog')->with($notification);

        }

    }
    public function DestroyBlog(string $id){
        $notification = array(
            'message' => 'Blog Deleted  Successfully',
            'alert-type' => 'success',
        );
//        DB::table('multi_images')->where('id', $id)->delete();
        $blog = Blog::query()->find($id);
        $img = $blog->blog_image;
        unlink($img);
        Blog::query()->findOrFail($id)->delete();

        return to_route('all.blog')->with($notification);


    }

    public function BlogDetails(string $id){
        $categories = BlogCategory::query()->orderBy('blog_category','ASC')->get();
        $allblogs = Blog::query()->latest()->limit(5)->get();
        $blogs =  Blog::query()->findOrFail($id);
        return view('frontend.blog_details',compact('blogs','allblogs','categories'));
    }
}

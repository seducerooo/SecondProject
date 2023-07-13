<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpParser\Node\Scalar\String_;

class BlogCategoryController extends Controller
{
    //
    public function AllBlogCategory(){
        $blogcategory = BlogCategory::query()->get()->all();
        return view('admin.blog_category.blog_category_all',compact('blogcategory'));
    }

    public function AddBlogCategory(){
        return view('admin.blog_category.blog_category_add');
    }

    public function StoreBlogCategory(Request $request){
        $request->validate([
            'blog_category' => 'required',

        ],
            [
                'blog_category.required' => 'Blog Category is required'

            ]
        );

        BlogCategory::query()->insert([
            'blog_category' => $request['blog_category'],
            'created_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Blog Category Created Successfully',
            'alert-type' => 'success',
        );
        return to_route('all.blog.category')->with($notification);

    }

    public function EditBlogCategory(string $id){
        $blogcategory = BlogCategory::query()->find($id);
        return view('admin.blog_category.blog_category_edit',compact('blogcategory'));
    }
    public function DeleteBlogCategory(string $id){
        $notification = array(
            'message' => 'Blog Category Deleted  Successfully',
            'alert-type' => 'success',
        );
//        DB::table('multi_images')->where('id', $id)->delete();

        BlogCategory::query()->findOrFail($id)->delete();

        return to_route('all.blog.category')->with($notification);
    }
    public function UpdateBlogCategory(String $id ,Request $request){

            $UpdateBlogCategory = BlogCategory::query()->find($id);
            $UpdateBlogCategory->blog_category = $request['blog_category'];
            $UpdateBlogCategory->updated_at = $request['updated_at'];
            $UpdateBlogCategory->save();

            $notification = array(
                'message' => ' Blog Category Updated  Successfully',
                'alert-type' => 'success',
            );
            return to_route('all.blog.category')->with($notification);
    }
}

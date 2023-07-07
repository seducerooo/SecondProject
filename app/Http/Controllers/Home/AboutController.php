<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //
    public function AboutPage(){
        $aboutpage =  About::query()->find(1);
        return view('admin.about_page.about_page_all',compact('aboutpage'));
    }
}

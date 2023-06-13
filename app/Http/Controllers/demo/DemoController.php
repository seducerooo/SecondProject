<?php

namespace App\Http\Controllers\demo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    //
    public function index(){

    }
    public function About(){
        return view('about');
    }
    public function Contact(){
        return view('contact');
    }
}

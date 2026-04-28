<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function blog()
    {
        return view('blog/blog');
    }   

    public function blogDetails()
    {
        return view('blog/blogDetails');
    }

    public function blogGridMinimal()
    {
        return view('blog/blogGridMinimal');
    }

    public function blogList()
    {
        return view('blog/blogList');
    }

    public function blogWithSidebar()
    {
        return view('blog/blogWithSidebar');
    }

    public function postFormatAudio()
    {
        return view('blog/postFormatAudio');
    }

    public function postFormatGallery()
    {
        return view('blog/postFormatGallery');
    }

    public function postFormatQuote()
    {
        return view('blog/postFormatQuote');
    }

    public function postFormatStandard()
    {
        return view('blog/postFormatStandard');
    }

    public function postFormatVideo()
    {
        return view('blog/postFormatVideo');
    }

}

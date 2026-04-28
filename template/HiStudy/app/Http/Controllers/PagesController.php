<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function pageError()
    {
        return view('pages/pageError');
    }

    public function aboutus01()
    {
        return view('pages/aboutus01');
    }

    public function aboutus02()
    {
        return view('pages/aboutus02');
    }

    public function academyGallery()
    {
        return view('pages/academyGallery');
    }

    public function admissionGuide()
    {
        return view('pages/admissionGuide');
    }

    public function becomeTeacher()
    {
        return view('pages/becomeTeacher');
    }

    public function cart()
    {
        return view('pages/cart');
    }

    public function contact()
    {
        return view('pages/contact');
    }

    public function eventDetails()
    {
        return view('pages/eventDetails');
    }

    public function eventGrid()
    {
        return view('pages/eventGrid');
    }

    public function eventList()
    {
        return view('pages/eventList');
    }

    public function eventSidebar()
    {
        return view('pages/eventSidebar');
    }

    public function faqs()
    {
        return view('pages/faqs');
    }

    public function instructor()
    {
        return view('pages/instructor');
    }

    public function login()
    {
        return view('pages/login');
    }

    public function maintenance()
    {
        return view('pages/maintenance');
    }

    public function myAccount()
    {
        return view('pages/myAccount');
    }

    public function privacyPolicy()
    {
        return view('pages/privacyPolicy');
    }

    public function profile()
    {
        return view('pages/profile');
    }

    public function shop()
    {
        return view('pages/shop');
    }

    public function singleProduct()
    {
        return view('pages/singleProduct');
    }

    public function subscription()
    {
        return view('pages/subscription');
    }

    public function wishlist2()
    {
        return view('pages/wishlist2');
    }

}

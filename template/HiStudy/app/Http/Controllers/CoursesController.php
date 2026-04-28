<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoursesController extends Controller
{

    public function courseCard2()
    {
        return view('courses/courseCard2');
    }

    public function courseCard3()
    {
        return view('courses/courseCard3');
    }

    public function courseDetails()
    {
        return view('courses/courseDetails');
    }

    public function courseDetails2()
    {
        return view('courses/courseDetails2');
    }

    public function courseDetails3()
    {
        return view('courses/courseDetails3');
    }

    public function courseFilterOneOpen()
    {
        return view('courses/courseFilterOneOpen');
    }

    public function courseFilterOneToggle()
    {
        return view('courses/courseFilterOneToggle');
    }

    public function courseFilterTwoOpen()
    {
        return view('courses/courseFilterTwoOpen');
    }

    public function courseFilterTwoToggle()
    {
        return view('courses/courseFilterTwoToggle');
    }

    public function courseMasonry()
    {
        return view('courses/courseMasonry');
    }

    public function courseWithSidebar()
    {
        return view('courses/courseWithSidebar');
    }

    public function courseWithTab()
    {
        return view('courses/courseWithTab');
    }

    public function courseWithTabTwo()
    {
        return view('courses/courseWithTabTwo');
    }

    public function createCourse()
    {
        return view('courses/createCourse');
    }

    public function instructorCourse()
    {
        return view('courses/instructorCourse');
    }

    public function lesson()
    {
        return view('courses/lesson');
    }

}

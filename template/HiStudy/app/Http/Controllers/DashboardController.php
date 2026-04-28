<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function instructorAnnouncements()
    {
        return view('dashboard/instructor-dashboard/instructorAnnouncements');
    }

    public function instructorAssignments()
    {
        return view('dashboard/instructor-dashboard/instructorAssignments');
    }

    public function instructorDashboard()
    {
        return view('dashboard/instructor-dashboard/instructorDashboard');
    }

    public function instructorEnrolledCourses()
    {
        return view('dashboard/instructor-dashboard/instructorEnrolledCourses');
    }

    public function instructorMyQuizAttempts()
    {
        return view('dashboard/instructor-dashboard/instructorMyQuizAttempts');
    }

    public function instructorOrderHistory()
    {
        return view('dashboard/instructor-dashboard/instructorOrderHistory');
    }

    public function instructorProfile()
    {
        return view('dashboard/instructor-dashboard/instructorProfile');
    }

    public function instructorQuizAttempts()
    {
        return view('dashboard/instructor-dashboard/instructorQuizAttempts');
    }

    public function instructorReviews()
    {
        return view('dashboard/instructor-dashboard/instructorReviews');
    }

    public function instructorSettings()
    {
        return view('dashboard/instructor-dashboard/instructorSettings');
    }

    public function instructorWishlist()
    {
        return view('dashboard/instructor-dashboard/instructorWishlist');
    }

    public function studentDashboard()
    {
        return view('dashboard/student-dashboard/studentDashboard');
    }

    public function studentEnrolledCourses()
    {
        return view('dashboard/student-dashboard/studentEnrolledCourses');
    }

    public function studentMyQuizAttempts()
    {
        return view('dashboard/student-dashboard/studentMyQuizAttempts');
    }

    public function studentOrderHistory()
    {
        return view('dashboard/student-dashboard/studentOrderHistory');
    }

    public function studentProfile()
    {
        return view('dashboard/student-dashboard/studentProfile');
    }

    public function studentReviews()
    {
        return view('dashboard/student-dashboard/studentReviews');
    }

    public function studentSettings()
    {
        return view('dashboard/student-dashboard/studentSettings');
    }

    public function studentWishlist()
    {
        return view('dashboard/student-dashboard/studentWishlist');
    }


}

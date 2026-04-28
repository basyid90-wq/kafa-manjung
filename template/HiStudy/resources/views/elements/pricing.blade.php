@extends('layout.layout')

@php
     $footer='true';
     $topToBottom='true';
@endphp

@section('content')

    <!-- Mobile Menu Section -->
    <div class="popup-mobile-menu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="content">
                    <div class="logo">
                        <div class="logo logo-dark">
                            <a href="#">
                                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Education Logo Images">
                            </a>
                        </div>

                        <div class="logo d-none logo-light">
                            <a href="#">
                                <img src="{{ asset('assets/images/dark/logo/logo-light.png') }}" alt="Education Logo Images">
                            </a>
                        </div>
                    </div>
                    <div class="rbt-btn-close">
                        <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
                <p class="description">Histudy is a education website template. You can customize all.</p>
                <ul class="navbar-top-left rbt-information-list justify-content-start">
                    <li>
                        <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                    </li>
                    <li>
                        <a href="#"><i class="feather-phone"></i>(302) 555-0107</a>
                    </li>
                </ul>
            </div>

            <nav class="mainmenu-nav">
                <ul class="mainmenu">
                    <li class="with-megamenu has-menu-child-item position-static">
                        <a href="#">Home <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu menu-skin-dark">
                            <div class="wrapper">
                                <div class="row row--15 home-plesentation-wrapper single-dropdown-menu-presentation">

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('mainDemo') }}"><img src="{{ asset('assets/images/splash/demo/h1.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('mainDemo') }}">Home Demo <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('marketplace') }}"><img src="{{ asset('assets/images/splash/demo/h12.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('marketplace') }}">Marketplace <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('kindergarten') }}"><img src="{{ asset('assets/images/splash/demo/h4.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('kindergarten') }}">kindergarten <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('universityClassic') }}"><img src="{{ asset('assets/images/splash/demo/h13.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('universityClassic') }}">University Classic <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('homeElegant') }}"><img src="{{ asset('assets/images/splash/demo/h14.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('homeElegant') }}">Home Elegant <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('gymCoaching') }}"><img src="{{ asset('assets/images/splash/demo/h9.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('gymCoaching') }}">Gym Coaching <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('onlineSchool') }}"><img src="{{ asset('assets/images/splash/demo/h3.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('onlineSchool') }}">Online School <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('universityStatus') }}"><img src="{{ asset('assets/images/splash/demo/h6.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('universityStatus') }}">University Status <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('homeTechnology') }}"><img src="{{ asset('assets/images/splash/demo/h15.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('homeTechnology') }}">Home Technology <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('instructorPortfolio') }}"><img src="{{ asset('assets/images/splash/demo/h7.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('instructorPortfolio') }}">Instructor Portfolio <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('languageAcademy') }}"><img src="{{ asset('assets/images/splash/demo/h8.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('languageAcademy') }}">Language Academy <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('singleCourse') }}"><img src="{{ asset('assets/images/splash/demo/h11.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('singleCourse') }}">Single Course <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('onlineCourse') }}"><img src="{{ asset('assets/images/splash/demo/h10.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('onlineCourse') }}">Online Course <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('classicLms') }}"><img src="{{ asset('assets/images/splash/demo/h5.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('classicLms') }}">Classic Lms <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('courseSchool') }}"><img src="{{ asset('assets/images/splash/demo/h2.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('courseSchool') }}">Course School <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('udemyAffiliate') }}"><img src="{{ asset('assets/images/splash/demo/h16.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('udemyAffiliate') }}">Udemy Affiliate <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('onlineAcademy') }}"><img src="{{ asset('assets/images/splash/demo/h17.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('onlineAcademy') }}">Online Academy <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('instructorsCoaches') }}"><img src="{{ asset('assets/images/splash/demo/h18.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('instructorsCoaches') }}">Instructor Coaches <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('modernUniversity') }}"><img src="{{ asset('assets/images/splash/demo/h19.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('modernUniversity') }}">Modern University <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('multilingual') }}"><img src="{{ asset('assets/images/splash/demo/h20.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('multilingual') }}">Multilingual <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('artDesignSchool') }}"><img src="{{ asset('assets/images/splash/demo/h21.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('artDesignSchool') }}">Art Design School <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('wishlist') }}"><img src="{{ asset('assets/images/splash/demo/h22.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('wishlist') }}">Wishlist <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('coaching') }}"><img src="{{ asset('assets/images/splash/demo/h23.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('coaching') }}">Coaching <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('healthWellnessInstitute') }}"><img src="{{ asset('assets/images/splash/demo/h24.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('healthWellnessInstitute') }}">Health Institute <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('lifeCoach') }}"><img src="{{ asset('assets/images/splash/demo/h25.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('lifeCoach') }}">Life Coach <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                    <!-- Start Single Demo  -->
                                    <div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">
                                        <div class="demo-single">
                                            <div class="inner">
                                                <div class="thumbnail">
                                                    <a href="{{ route('islamicCenter') }}"><img src="{{ asset('assets/images/splash/demo/h26.jpg') }}" alt="Demo Images"></a>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title"><a href="{{ route('islamicCenter') }}">Islamic Center <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Demo  -->

                                </div>

                                <div class="load-demo-btn-wrap">
                                    <div class="load-demo-btn text-center">
                                        <span class="color-white b3">Scroll to view more <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"/>
                              </svg></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>

                    <li class="with-megamenu has-menu-child-item">
                        <a href="#">Courses <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu grid-item-2">
                            <div class="wrapper">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mega-top-banner">
                                            <div class="content">
                                                <h4 class="title">Developer hub</h4>
                                                <p class="description">Start building fast, with code samples, key resources and more.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row--15">
                                    <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                        <h3 class="rbt-short-title">Course Layout</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('courseFilterOneToggle') }}">Filter One Toggle</a></li>
                                            <li><a href="{{ route('courseFilterOneOpen') }}">Filter One Open</a></li>
                                            <li><a href="{{ route('courseFilterTwoToggle') }}">Filter Two Toggle</a></li>
                                            <li><a href="{{ route('courseFilterTwoOpen') }}">Filter Two Open</a></li>
                                            <li><a href="{{ route('courseWithTab') }}">Course With Tab</a></li>
                                            <li><a href="{{ route('courseWithTabTwo') }}">Course With Tab Two</a></li>
                                            <li><a href="{{ route('courseCard2') }}">Course Card Two</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-xl-6 col-xxl-6 single-mega-item">
                                        <h3 class="rbt-short-title">Course Layout</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('courseCard3') }}">Course Card Three</a></li>
                                            <li><a href="{{ route('courseMasonry') }}">Course Masonry</a></li>
                                            <li><a href="{{ route('courseWithSidebar') }}">Course With Sidebar</a></li>
                                            <li><a href="{{ route('courseDetails') }}">Course Details</a></li>
                                            <li><a href="{{ route('courseDetails2') }}">Course Details Two</a></li>
                                            <li><a href="{{ route('lesson') }}">Course Lesson <span class="rbt-badge-card">New</span></a></li>
                                            <li><a href="{{ route('createCourse') }}">Create Course <span class="rbt-badge-card">New</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="nav-quick-access">
                                            <li><a href="#"><i class="feather-folder-minus"></i> Quick Start Guide</a></li>
                                            <li><a href="#"><i class="feather-folder-minus"></i> For Open Source</a></li>
                                            <li><a href="#"><i class="feather-folder-minus"></i> API Status</a></li>
                                            <li><a href="#"><i class="feather-folder-minus"></i> Support</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>

                    <li class="has-dropdown has-menu-child-item">
                        <a href="#">Dashboard
                            <i class="feather-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li class="has-dropdown"><a href="#">Instructor Dashboard</a>
                                <ul class="submenu">
                                    <li><a href="{{ route('instructorDashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('instructorProfile') }}">Profile</a></li>
                                    <li><a href="{{ route('instructorEnrolledCourses') }}">Enrolled Courses</a></li>
                                    <li><a href="{{ route('instructorWishlist') }}">Wishlist</a></li>
                                    <li><a href="{{ route('instructorReviews') }}">Reviews</a></li>
                                    <li><a href="{{ route('instructorMyQuizAttempts') }}">My Quiz Attempts</a></li>
                                    <li><a href="{{ route('instructorOrderHistory') }}">Order History</a></li>
                                    <li><a href="{{ route('instructorCourse') }}">My Course</a></li>
                                    <li><a href="{{ route('instructorAnnouncements') }}">Announcements</a></li>
                                    <li><a href="{{ route('instructorQuizAttempts') }}">Quiz Attempts</a></li>
                                    <li><a href="{{ route('instructorAssignments') }}">Assignments</a></li>
                                    <li><a href="{{ route('instructorSettings') }}">Settings</a></li>
                                </ul>
                            </li>
                            <li class="has-dropdown"><a href="#">Student Dashboard</a>
                                <ul class="submenu">
                                    <li><a href="{{ route('studentDashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('studentProfile') }}">Profile</a></li>
                                    <li><a href="{{ route('studentEnrolledCourses') }}">Enrolled Courses</a></li>
                                    <li><a href="{{ route('studentWishlist') }}">Wishlist</a></li>
                                    <li><a href="{{ route('studentReviews') }}">Reviews</a></li>
                                    <li><a href="{{ route('studentMyQuizAttempts') }}">My Quiz Attempts</a></li>
                                    <li><a href="{{ route('studentOrderHistory') }}">Order History</a></li>
                                    <li><a href="{{ route('studentSettings') }}">Settings</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="with-megamenu has-menu-child-item position-static">
                        <a href="#">Pages <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu grid-item-4">
                            <div class="wrapper">
                                <div class="row row--15">
                                    <div class="col-lg-12 col-xl-3 col-xxl-3 single-mega-item">
                                        <h3 class="rbt-short-title">Get Started</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('aboutus01') }}">About Us</a></li>
                                            <li><a href="{{ route('aboutus02') }}">About Us 02</a></li>
                                            <li><a href="{{ route('eventGrid') }}">Event Grid</a></li>
                                            <li><a href="{{ route('eventList') }}">Event List</a></li>
                                            <li><a href="{{ route('eventSidebar') }}">Event Sidebar</a></li>
                                            <li><a href="{{ route('eventDetails') }}">Event Details</a></li>
                                            <li><a href="{{ route('academyGallery') }}">Academy Gallery</a></li>
                                            <li><a href="{{ route('admissionGuide') }}">Admission Guide</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-12 col-xl-3 col-xxl-3 single-mega-item">
                                        <h3 class="rbt-short-title">Get Started</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('profile') }}">Profile</a></li>
                                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                            <li><a href="{{ route('becomeTeacher') }}">Become a Teacher</a></li>
                                            <li><a href="{{ route('instructor') }}">Instructor</a></li>
                                            <li><a href="{{ route('faqs') }}">FAQS</a></li>
                                            <li><a href="{{ route('privacyPolicy') }}">Privacy Policy</a></li>
                                            <li><a href="{{ route('pageError') }}">404 Page</a></li>
                                            <li><a href="{{ route('maintenance') }}">Maintenance</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-12 col-xl-3 col-xxl-3 single-mega-item">
                                        <h3 class="rbt-short-title">Shop Pages</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('shop') }}">Shop <span class="rbt-badge-card">Sale Anything</span></a></li>
                                            <li><a href="{{ route('singleProduct') }}">Single Product</a></li>
                                            <li><a href="{{ route('cart') }}">Cart Page</a></li>
                                            <li><a href="{{ route('checkout') }}">Checkout</a></li>
                                            <li><a href="{{ route('wishlist') }}">Wishlist Page</a></li>
                                            <li><a href="{{ route('myAccount') }}">My Acount</a></li>
                                            <li><a href="{{ route('login') }}">Login & Register</a></li>
                                            <li><a href="{{ route('subscription') }}">Subscription</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-xl-3 col-xxl-3 single-mega-item">
                                        <div class="mega-category-item">
                                            <!-- Start Single Category  -->
                                            <div class="nav-category-item">
                                                <div class="thumbnail">
                                                    <div class="image"><img src="{{ asset('assets/images/course/category-2.png') }}" alt="Course images"></div>
                                                    <a href="{{ route('courseFilterOneToggle') }}">
                                                        <span>Online Education</span>
                                                        <i class="feather-chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Single Category  -->

                                            <!-- Start Single Category  -->
                                            <div class="nav-category-item">
                                                <div class="thumbnail">
                                                    <div class="image"><img src="{{ asset('assets/images/course/category-1.png') }}" alt="Course images"></div>
                                                    <a href="{{ route('courseFilterOneToggle') }}">
                                                        <span>Language Club</span>
                                                        <i class="feather-chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Single Category  -->

                                            <!-- Start Single Category  -->
                                            <div class="nav-category-item">
                                                <div class="thumbnail">
                                                    <div class="image"><img src="{{ asset('assets/images/course/category-4.png') }}" alt="Course images"></div>
                                                    <a href="{{ route('courseFilterOneToggle') }}">
                                                        <span>University Status</span>
                                                        <i class="feather-chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Single Category  -->

                                            <!-- Start Single Category  -->
                                            <div class="nav-category-item">
                                                <div class="thumbnail">
                                                    <a href="{{ route('courseFilterOneToggle') }}">
                                                        <span>Course School</span>
                                                        <i class="feather-chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Single Category  -->

                                            <!-- Start Single Category  -->
                                            <div class="nav-category-item">
                                                <div class="thumbnail">
                                                    <div class="image"><img src="{{ asset('assets/images/course/category-9.png') }}" alt="Course images"></div>
                                                    <a href="{{ route('courseFilterOneToggle') }}">
                                                        <span>Academy</span>
                                                        <i class="feather-chevron-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Single Category  -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>

                    <li class="with-megamenu has-menu-child-item position-static">
                        <a href="#">Elements <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu grid-item-3">
                            <div class="wrapper">
                                <div class="row row--15 single-dropdown-menu-presentation">
                                    <div class="col-lg-4 col-xxl-4 single-mega-item">
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('styleGuide') }}">Style Guide <span class="rbt-badge-card">Hot</span></a></li>
                                            <li><a href="{{ route('accordion') }}">Accordion</a></li>
                                            <li><a href="{{ route('advancetab') }}">Advance Tab</a></li>
                                            <li><a href="{{ route('about') }}">About <span class="rbt-badge-card">New</span></a></li>
                                            <li><a href="{{ route('brand') }}">Brand</a></li>
                                            <li><a href="{{ route('button') }}">Button</a></li>
                                            <li><a href="{{ route('badge') }}">Badge</a></li>
                                            <li><a href="{{ route('card') }}">Card</a></li>
                                            <li><a href="#">& More Coming</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-4 col-xxl-4 single-mega-item">
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('callToAction') }}">Call To Action</a></li>
                                            <li><a href="{{ route('counterup') }}">Counter</a></li>
                                            <li><a href="{{ route('category') }}">Categories</a></li>
                                            <li><a href="{{ route('header') }}">Header Style</a></li>
                                            <li><a href="{{ route('newsletter') }}">Newsletter</a></li>
                                            <li><a href="{{ route('team') }}">Team</a></li>
                                            <li><a href="{{ route('social') }}">Social</a></li>
                                            <li><a href="{{ route('listStyle') }}">List Style</a></li>
                                            <li><a href="#">& More Coming</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-4 col-xxl-4 single-mega-item">
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('gallery') }}">Gallery</a></li>
                                            <li><a href="{{ route('pricing') }}">Pricing</a></li>
                                            <li><a href="{{ route('progressbar') }}">Progressbar</a></li>
                                            <li><a href="{{ route('testimonial') }}">Testimonial</a></li>
                                            <li><a href="{{ route('service') }}">Service</a></li>
                                            <li><a href="{{ route('split') }}">Split Area</a></li>
                                            <li><a href="{{ route('search') }}">Search Style</a></li>
                                            <li><a href="{{ route('instagram') }}">Instagram Style</a></li>
                                            <li><a href="#">& More Coming</a></li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-wrapper">
                                            <a class="rbt-btn btn-gradient hover-icon-reverse square btn-xl w-100 text-center mt--30 hover-transform-none" href="#">
                                                <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Visit Histudy Template</span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>

                    <li class="with-megamenu has-menu-child-item position-static">
                        <a href="#">Blog <i class="feather-chevron-down"></i></a>
                        <!-- Start Mega Menu  -->
                        <div class="rbt-megamenu grid-item-3">
                            <div class="wrapper">
                                <div class="row row--15">
                                    <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                        <h3 class="rbt-short-title">Blog Styles</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('blogList') }}">Blog List</a></li>
                                            <li><a href="{{ route('blog') }}">Blog Grid</a></li>
                                            <li><a href="{{ route('blogGridMinimal') }}">Blog Grid Minimal</a></li>
                                            <li><a href="{{ route('blogWithSidebar') }}">Blog With Sidebar</a></li>
                                            <li><a href="{{ route('blogDetails') }}">Blog Details</a></li>
                                            <li><a href="{{ route('postFormatStandard') }}">Post Format Standard</a></li>
                                            <li><a href="{{ route('postFormatGallery') }}">Post Format Gallery</a></li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                        <h3 class="rbt-short-title">Get Started</h3>
                                        <ul class="mega-menu-item">
                                            <li><a href="{{ route('postFormatQuote') }}">Post Format Quote</a></li>
                                            <li><a href="{{ route('postFormatAudio') }}">Post Format Audio</a></li>
                                            <li><a href="{{ route('postFormatVideo') }}">Post Format Video</a></li>
                                            <li><a href="#">Media Under Title <span class="rbt-badge-card">Coming</span></a></li>
                                            <li><a href="#">Sticky Sidebar <span class="rbt-badge-card">Coming</span></a></li>
                                            <li><a href="#">Auto Masonry <span class="rbt-badge-card">Coming</span></a></li>
                                            <li><a href="#">Meta Overlaid <span class="rbt-badge-card">Coming</span></a></li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-12 col-xl-4 col-xxl-4 single-mega-item">
                                        <div class="rbt-ads-wrapper">
                                            <a class="d-block" href="#"><img src="{{ asset('assets/images/service/mobile-cat.jpg') }}" alt="Education Images"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Mega Menu  -->
                    </li>
                </ul>
            </nav>

            <div class="mobile-menu-bottom">
                <div class="rbt-btn-wrapper mb--20">
                    <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center" href="#">
                        <span>Enroll Now</span>
                    </a>
                </div>

                <div class="social-share-wrapper">
                    <span class="rbt-short-title d-block">Find With Us</span>
                    <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                        <li><a href="https://www.facebook.com/">
                                <i class="feather-facebook"></i>
                            </a>
                        </li>
                        <li><a href="https://www.twitter.com">
                                <i class="feather-twitter"></i>
                            </a>
                        </li>
                        <li><a href="https://www.instagram.com/">
                                <i class="feather-instagram"></i>
                            </a>
                        </li>
                        <li><a href="https://www.linkdin.com/">
                                <i class="feather-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <!-- Start Side Vav -->
    <x-sideVav/>
    <!-- End Side Vav -->

    <a class="close_side_menu" href="javascript:void(0);"></a>
    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default ptb--100 ptb_md--50 ptb_sm--30 bg-gradient-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner text-center">
                        <h2 class="title">Pricing</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="#">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Pricing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="rbt-pricing-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-primary-opacity">COURSE PRICING</span>
                        <h2 class="title">Style One</h2>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                    <div class="pricing-billing-duration text-start text-md-end">
                        <ul>
                            <li class="nav-item">
                                <button class="nav-link yearly-plan-btn" type="button">Yearly Plan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link monthly-plan-btn active" type="button">Monthly Plan</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3 class="title">Basic Plan</h3>
                            <span class="rbt-badge mb--35">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$30.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$8.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li><i class="feather-check"></i> High Resolution Videos</li>
                                <li><i class="feather-check"></i> 24/7 Dedicated Support</li>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table active">
                        <div class="pricing-header">
                            <h3 class="title">Standard Plan</h3>
                            <span class="rbt-badge mb--35">Most Popular</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$100.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$20.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li><i class="feather-check"></i> High Resolution Videos</li>
                                <li><i class="feather-check"></i> 24/7 Dedicated Support</li>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table">
                        <div class="pricing-header">
                            <h3 class="title">Exclusive Plan</h3>
                            <span class="rbt-badge mb--35">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$99.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$39.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li><i class="feather-check"></i> High Resolution Videos</li>
                                <li><i class="feather-check"></i> 24/7 Dedicated Support</li>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->
            </div>
        </div>
    </div>

    <div class="rbt-pricing-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">COURSE PRICING</span>
                        <h2 class="title">Style Two</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="pricing-billing-duration text-start text-md-end">
                        <ul>
                            <li class="nav-item">
                                <button class="nav-link yearly-plan-btn" type="button">Yearly Plan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link monthly-plan-btn active" type="button">Monthly Plan</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2">
                        <div class="pricing-header">
                            <h3 class="title">Basic Plan</h3>
                            <span class="rbt-badge mb--35">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$30.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$10.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-btn">
                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>

                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li class="off"><i class="feather-x"></i> 24/7 Dedicated Support</li>
                                <li class="off"><i class="feather-x"></i> Unlimited Emails</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2 active">
                        <div class="pricing-header">
                            <div class="pricing-badge"><span>Popular</span></div>
                            <h3 class="title">Standard Plan</h3>
                            <span class="rbt-badge mb--35">Most Popular</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$100.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$20.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>

                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li><i class="feather-check"></i> High Resolution Videos</li>
                                <li><i class="feather-check"></i> 24/7 Dedicated Support</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2">
                        <div class="pricing-header">
                            <h3 class="title">Exclusive Plan</h3>
                            <span class="rbt-badge mb--35">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$99.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$39.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-btn">
                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>

                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li class="off"><i class="feather-x"></i> 24/7 Dedicated Support</li>
                                <li class="off"><i class="feather-x"></i> Unlimited Emails</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- End Single Pricing  -->
            </div>
        </div>
    </div>

    <div class="rbt-pricing-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-secondary-opacity">COURSE PRICING</span>
                        <h2 class="title">Style Three</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="pricing-billing-duration text-start text-md-end">
                        <ul>
                            <li class="nav-item">
                                <button class="nav-link yearly-plan-btn" type="button">Yearly Plan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link monthly-plan-btn active" type="button">Monthly Plan</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2">
                        <div class="pricing-header">
                            <h3 class="title color-primary">Basic Plan</h3>
                            <span class="rbt-badge mb--35">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount color-primary">$30.99</span>
                                    <span class="duration color-primary">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount color-primary">$10.00</span>
                                    <span class="duration color-primary">/monthly</span>
                                </div>
                            </div>
                        </div>

                        <div class="pricing-btn">
                            <a class="rbt-btn bg-primary-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>

                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li class="off"><i class="feather-x"></i> 24/7 Dedicated Support</li>
                                <li class="off"><i class="feather-x"></i> Unlimited Emails</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2 active">
                        <div class="pricing-header">
                            <div class="pricing-badge"><span>Popular</span></div>
                            <h3 class="title color-secondary">Standard Plan</h3>
                            <span class="rbt-badge mb--35">Most Popular</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount color-secondary">$100.99</span>
                                    <span class="duration color-secondary">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount color-secondary">$20.00</span>
                                    <span class="duration color-secondary">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn bg-secondary-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>

                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li><i class="feather-check"></i> High Resolution Videos</li>
                                <li><i class="feather-check"></i> 24/7 Dedicated Support</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-2">
                        <div class="pricing-header">
                            <h3 class="title color-pink">Exclusive Plan</h3>
                            <span class="rbt-badge mb--35">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount color-pink">$99.99</span>
                                    <span class="duration color-pink">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount color-pink">$39.00</span>
                                    <span class="duration color-pink">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn bg-pink-opacity hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>

                        <div class="pricing-body">
                            <ul class="list-item">
                                <li><i class="feather-check"></i> Unlimited Access Courses</li>
                                <li><i class="feather-check"></i> Certificate After Completion</li>
                                <li class="off"><i class="feather-x"></i> 24/7 Dedicated Support</li>
                                <li class="off"><i class="feather-x"></i> Unlimited Emails</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- End Single Pricing  -->
            </div>
        </div>
    </div>

    <div class="rbt-pricing-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">COURSE PRICING</span>
                        <h2 class="title">Style Four</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="pricing-billing-duration text-start text-md-end">
                        <ul>
                            <li class="nav-item">
                                <button class="nav-link yearly-plan-btn" type="button">Yearly Plan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link monthly-plan-btn active" type="button">Monthly Plan</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row gx-0 ">
                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-3">
                        <div class="icon-image text-center">
                            <img src="{{ asset('assets/images/icons/pricing-icon-01.png') }}" alt="Pricing Image Icons">
                        </div>
                        <div class="pricing-header">
                            <h3 class="title">6 weeks to 12 months</h3>
                            <span class="rbt-badge mb--15">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$1475</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$12.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-item">
                                <li>5 Full Days</li>
                                <li>7:00 am to 6:00 pm</li>
                                <li class="off">High Resolution Videos</li>
                                <li class="off">24/7 Dedicated Support</li>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn btn-border radius-round hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-3 active">
                        <div class="icon-image text-center">
                            <img src="{{ asset('assets/images/icons/pricing-icon-02.png') }}" alt="Pricing Image Icons">
                        </div>
                        <div class="pricing-header">
                            <h3 class="title">12 months to 24 months</h3>
                            <span class="rbt-badge mb--15">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$30.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$20.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-item">
                                <li>8 Full Days</li>
                                <li>7:00 am to 6:00 pm</li>
                                <li class="off">High Resolution Videos</li>
                                <li class="off">24/7 Dedicated Support</li>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn btn-gradient radius-round hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

                <!-- Start Single Pricing  -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                    <div class="pricing-table style-3">
                        <div class="icon-image text-center">
                            <img src="{{ asset('assets/images/icons/pricing-icon-03.png') }}" alt="Pricing Image Icons">
                        </div>
                        <div class="pricing-header">
                            <h3 class="title">Pre Primary Community</h3>
                            <span class="rbt-badge mb--15">Free for a Month</span>
                            <div class="price-wrap">
                                <div class="yearly-pricing" style="display: none;">
                                    <span class="amount">$1245.99</span>
                                    <span class="duration">/yearly</span>
                                </div>
                                <div class="monthly-pricing" style="display: block;">
                                    <span class="amount">$30.00</span>
                                    <span class="duration">/monthly</span>
                                </div>
                            </div>
                        </div>
                        <div class="pricing-body">
                            <ul class="list-item">
                                <li>Pre Primary Community</li>
                                <li>Kindergarten Community</li>
                                <li>High Resolution Videos</li>
                                <li>24/7 Dedicated Support</li>
                            </ul>
                        </div>
                        <div class="pricing-btn">
                            <a class="rbt-btn btn-border radius-round hover-icon-reverse w-100" href="#">
                                <div class="icon-reverse-wrapper">
                                    <span class="btn-text">Join Course Plan</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Single Pricing  -->

            </div>
        </div>
    </div>

    <div class="rbt-pricing-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 mb--60">
                <div class="col-12">
                    <div class="section-title text-center">
                        <span class="subtitle bg-pink-opacity">COURSE PRICING</span>
                        <h2 class="title">Style Five</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="advance-pricing">
                        <div class="inner">
                            <div class="row row--0">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="pricing-left">
                                        <h3 class="main-title">Active Plan Mode.</h3>
                                        <p class="description">Lorem ipsum dolor sit amet consectetur
                                            adipisicing elit. Nemo, quisquam.</p>
                                        <div class="price-wrapper">
                                            <span class="price-amount">$129<sup>/mo</sup></span>
                                        </div>
                                        <div class="pricing-btn-group">
                                            <button class="rbt-btn btn-gradient w-100">Purchase Now</button>
                                            <button class="rbt-btn btn-border w-100">Upgrade</button>
                                        </div>
                                        <div class="rating">
                                            <a href="#rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </a>
                                            <a href="#rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </a>
                                            <a href="#rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </a>
                                            <a href="#rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </a>
                                            <a href="#rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        <small class="subtitle">rated 4.5/5 Stars in 1000+ reviews.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="pricing-right position-relative">
                                        <div class="pricing-offer">
                                            <div class="single-list">
                                                <h4 class="price-title">Advance Plans You can Get.</h4>
                                                <ul class="plan-offer-list">
                                                    <li>
                                                        <i class="feather-check"></i> 5 PPC Campaigns
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> Digital Marketing
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> Marketing Agency
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> Seo Friendly
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="single-list mt--40">
                                                <h4 class="price-title">Basic Plans You can Get.</h4>
                                                <ul class="plan-offer-list">
                                                    <li>
                                                        <i class="feather-check"></i> 5 PPC Campaigns
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> Digital Marketing
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> Marketing Agency
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> Seo Friendly
                                                    </li>
                                                    <li>
                                                        <i class="feather-check"></i> App Development
                                                    </li>
                                                    <li class="off">
                                                        <i class="feather-x"></i> 24/7 Dedicated Support
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="pricing-badge"><span>Popular</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-separator/>
    
@endsection
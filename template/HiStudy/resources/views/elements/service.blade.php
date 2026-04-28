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
                        <h2 class="title">Service Box</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="#">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Service Box</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style One.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">

                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-1">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-1.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Best Coaching</a></h5>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-2">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-2.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Convenient practice</a></h5>
                                    <p>Convenient practice dolor sit adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <p>Convenient practice dolor sit adipisicing elit. Minima error reiciendis.</p>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-3">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-3.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Video Lecture</a></h5>
                                    <p>Video Lecture sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <p>Video Lecture sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-4">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-4.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Live Class</a></h5>
                                    <p>Live Class dolor sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <p>Live Class dolor sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Two.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row row--15 mt_dec--30">

                <!-- Start Single Card  -->
                <div class="col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">React</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-01.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">English</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-02.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">Education</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-03.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Three.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="swiper service-item-3-activation  rbt-arrow-between gutter-swiper-30">

                <div class="swiper-wrapper">
                    <!-- Start Single Card  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-service rbt-service-2 rbt-hover-02 bg-no-shadow card-bg-1">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="title"><a href="#">React</a></h4>
                                        <p>React Js dolor sit, amet consectetur.</p>
                                        <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                                    </div>
                                    <div class="thumbnail">
                                        <img src="{{ asset('assets/images/service/service-06.png') }}" alt="Education Images">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->
                    <!-- Start Single Card  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-service rbt-service-2 rbt-hover-02 bg-no-shadow card-bg-2">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="title"><a href="#">English</a></h4>
                                        <p>Spken english dolor sit, amet consectetur.</p>
                                        <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                                    </div>
                                    <div class="thumbnail">
                                        <img src="{{ asset('assets/images/service/service-05.png') }}" alt="Education Images">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->
                    <!-- Start Single Card  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-service rbt-service-2 rbt-hover-02 bg-no-shadow card-bg-3">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="title"><a href="#">Education</a></h4>
                                        <p>Eearning edu dolor sit, amet consectetur.</p>
                                        <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                                    </div>
                                    <div class="thumbnail">
                                        <img src="{{ asset('assets/images/service/service-03.png') }}" alt="Education Images">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->

                    <!-- Start Single Card  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-service rbt-service-2 rbt-hover-02 bg-no-shadow card-bg-4">
                                <div class="inner">
                                    <div class="content">
                                        <h4 class="title"><a href="#">Education</a></h4>
                                        <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                        <a class="transparent-button" href="#">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"/><path stroke-linecap="square" d="M.663 5.572h14.594"/></g></svg></i></a>
                                    </div>
                                    <div class="thumbnail">
                                        <img src="{{ asset('assets/images/service/service-04.png') }}" alt="Education Images">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->
                </div>

                <div class="rbt-swiper-arrow rbt-arrow-left">
                    <div class="custom-overfolow">
                        <i class="rbt-icon feather-arrow-left"></i>
                        <i class="rbt-icon-top feather-arrow-left"></i>
                    </div>
                </div>

                <div class="rbt-swiper-arrow rbt-arrow-right">
                    <div class="custom-overfolow">
                        <i class="rbt-icon feather-arrow-right"></i>
                        <i class="rbt-icon-top feather-arrow-right"></i>
                    </div>
                </div>
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Four.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row g-5">
                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-01.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Chemistry</a></h6>
                                <p class="description">5+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-02.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Accounting</a></h6>
                                <p class="description">40+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-03.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Management</a></h6>
                                <p class="description">60+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-04.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Art & Design</a></h6>
                                <p class="description">20+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-05.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Biology</a></h6>
                                <p class="description">20+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-06.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Marketing</a></h6>
                                <p class="description">20+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-07.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Astrology</a></h6>
                                <p class="description">25+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12">
                    <div class="service-card service-card-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/icon-08.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Engineering </a></h6>
                                <p class="description">10+ Course</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Five.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row row--15 mt_dec--30">

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/001-bulb.png') }}" alt="icons Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Your Apply</a></h6>
                                <p class="description">English Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/002-hat.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">We Connect</a></h6>
                                <p class="description">Javascript Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/003-id-card.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">You Get Ready</a></h6>
                                <p class="description">Angular Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/004-pass.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Modern Skills</a></h6>
                                <p class="description">Php Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Six.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row row--15 mt_dec--30">
                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-1">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-01.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-01.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Grow Confident</a></h6>
                                <p class="description">English Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-2">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-04.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-04.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Accive Good Job</a></h6>
                                <p class="description">Javascript Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-3">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-03.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-03.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Best Learning</a></h6>
                                <p class="description">Angular Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-4">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-02.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-02.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Modern Skills</a></h6>
                                <p class="description">Php Learning looking for random paragraphs, you've come to the right place. When a random.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Seven.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row row--15 mt_dec--30">
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="section-title text-start">
                        <h2 class="title">What will you learn after the course?.</h2>
                        <p class="description mt--20">There are many variations of passages of the Ipsum available.</p>
                        <div class="read-more-btn">
                            <a class="rbt-btn btn-gradient radius rbt-marquee-btn marquee-text-y" href="#">
                                <span data-text="About More Us">
                        About More Us
                    </span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-1">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-01.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-01.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">English Learning</a></h6>
                                <p class="description">English Learning looking for random paragraphs, you've come to the right place. When a random word.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-2">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-04.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-04.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Javascript Learning</a></h6>
                                <p class="description">Javascript Learning looking for random paragraphs, you've come to the right place. When a random word.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-3">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-03.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-03.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Angular Learning</a></h6>
                                <p class="description">Angular Learning looking for random paragraphs, you've come to the right place. When a random word.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-4">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-02.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-02.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Php Learning</a></h6>
                                <p class="description">Php Learning looking for random paragraphs, you've come to the right place. When a random word.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-4 col-xxl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-5">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/shape/service-05.png') }}" alt="Shape Images">
                                <img class="opacity_image" src="{{ asset('assets/images/shape/service-05.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Spoken English</a></h6>
                                <p class="description">Spoken english looking for random paragraphs, you've come to the right place. When a random word.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Eight.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row g-5">
                <!-- Start Service Grid  -->
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-3 col-sm-4 col-6">
                    <div class="service-card service-card-5 variation-2">
                        <div class="inner">
                            <div class="icon">
                                <a href="#"><img src="{{ asset('assets/images/category/image/web-design.jpg') }}" alt="Shape Images"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Chemistry</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-3 col-sm-4 col-6">
                    <div class="service-card service-card-5 variation-2">
                        <div class="inner">
                            <div class="icon">
                                <a href="#"><img src="{{ asset('assets/images/category/image/graphic-design.jpg') }}" alt="Shape Images"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Graphic Design</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-3 col-sm-4 col-6">
                    <div class="service-card service-card-5 variation-2">
                        <div class="inner">
                            <div class="icon">
                                <a href="#"><img src="{{ asset('assets/images/category/image/software.jpg') }}" alt="Shape Images"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Software</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-3 col-sm-4 col-6">
                    <div class="service-card service-card-5 variation-2">
                        <div class="inner">
                            <div class="icon">
                                <a href="#"><img src="{{ asset('assets/images/category/image/mobile.jpg') }}" alt="Shape Images"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Mobile App</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-3 col-sm-4 col-6">
                    <div class="service-card service-card-5 variation-2">
                        <div class="inner">
                            <div class="icon">
                                <a href="#"><img src="{{ asset('assets/images/category/image/finance.jpg') }}" alt="Shape Images"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Finance</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-2 col-xl-2 col-xxl-2 col-md-3 col-sm-4 col-6">
                    <div class="service-card service-card-5 variation-2">
                        <div class="inner">
                            <div class="icon">
                                <a href="#"><img src="{{ asset('assets/images/category/image/arts.jpg') }}" alt="Shape Images"></a>
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Art & Humanities</a></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-service-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Nine.</h2>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-1">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-1.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Best Coaching</a></h5>
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <ul class="rbt-list-style-3 color-white">
                                    <li><i class="feather-youtube"></i> 570 Free Video</li>
                                    <li><i class="feather-book"></i> 35 Subjects</li>
                                    <li><i class="feather-video"></i> Live Class</li>
                                    <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                </ul>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-2">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-2.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Convenient practice</a></h5>
                                    <p>Convenient practice dolor sit adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <ul class="rbt-list-style-3 color-white">
                                    <li><i class="feather-youtube"></i> 370 Free Video</li>
                                    <li><i class="feather-book"></i> 120 Subjects</li>
                                    <li><i class="feather-video"></i> Live Class</li>
                                    <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                </ul>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-3">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-3.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Video Lecture</a></h5>
                                    <p>Video Lecture sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <ul class="rbt-list-style-3 color-white">
                                    <li><i class="feather-youtube"></i> 125 Free Video</li>
                                    <li><i class="feather-book"></i> 12 Subjects</li>
                                    <li><i class="feather-video"></i> Live Class</li>
                                    <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                </ul>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-4">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="icon">
                                    <img src="{{ asset('assets/images/icons/card-icon-4.png') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Live Class</a></h5>
                                    <p>Live Class dolor sit, amet consectetur adipisicing elit. Minima error reiciendis.</p>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <ul class="rbt-list-style-3 color-white">
                                    <li><i class="feather-youtube"></i> 124 Free Video</li>
                                    <li><i class="feather-book"></i> 56 Subjects</li>
                                    <li><i class="feather-video"></i> Live Class</li>
                                    <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                </ul>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

            </div>
            <!-- End Card Area -->
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-rbt-card-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Ten.</h2>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">

                <!-- Start Single Card  -->
                <div class="col-xl-6 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 variation-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">BCS Exam</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-youtube"></i> 125 Free Video</li>
                                            <li><i class="feather-book"></i> 12 Subjects</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-video"></i> Live Class</li>
                                            <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                        </ul>
                                    </div>
                                </div>
                                <a class="rbt-btn btn-gradient hover-icon-reverse btn-sm mt--30" href="#">
                                    <span class="icon-reverse-wrapper">
                            <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-01.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-6 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 variation-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">Medical Exam</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-youtube"></i> 785 Free Video</li>
                                            <li><i class="feather-book"></i> 95 Subjects</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-video"></i> Live Class</li>
                                            <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                        </ul>
                                    </div>
                                </div>
                                <a class="rbt-btn btn-gradient hover-icon-reverse btn-sm mt--30" href="#">
                                    <span class="icon-reverse-wrapper">
                            <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-02.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-6 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 variation-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">University Admit Exam</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-youtube"></i> 123 Free Video</li>
                                            <li><i class="feather-book"></i> 85 Subjects</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-video"></i> Live Class</li>
                                            <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                        </ul>
                                    </div>
                                </div>
                                <a class="rbt-btn btn-gradient hover-icon-reverse btn-sm mt--30" href="#">
                                    <span class="icon-reverse-wrapper">
                            <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-03.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-6 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-service rbt-service-2 variation-2 rbt-hover-02">
                        <div class="inner">
                            <div class="content">
                                <h4 class="title"><a href="#">IELTS Exam</a></h4>
                                <p>Lorem ipsum dolor sit, amet consectetur.</p>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-youtube"></i> 150 Free Video</li>
                                            <li><i class="feather-book"></i> 26 Subjects</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <ul class="rbt-list-style-3">
                                            <li><i class="feather-video"></i> Live Class</li>
                                            <li><i class="feather-info"></i> MCQ and CQ Bank</li>
                                        </ul>
                                    </div>
                                </div>
                                <a class="rbt-btn btn-gradient hover-icon-reverse btn-sm mt--30" href="#">
                                    <span class="icon-reverse-wrapper">
                            <span class="btn-text">Read More</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/service/service-03.png') }}" alt="Education Images">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->
            </div>
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-rbt-card-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Eleven.</h2>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Card  -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox variation-2">

                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-1">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="front-thumb w-100">
                                    <img src="{{ asset('assets/images/flip/kindergarten-01-front.jpg') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Infant</a></h5>
                                    <ul class="rbt-list-style-3">
                                        <li><i class="feather-heart"></i> Health and Wellness</li>
                                        <li><i class="feather-flag"></i> Literacy and Language</li>
                                        <li><i class="feather-eye"></i> Social-Emotional Learning</li>
                                        <li><i class="feather-edit-2"></i> Visual and Creative Arts
                                        </li>
                                        <li><i class="feather-battery-charging"></i> Thinking and Learning</li>
                                    </ul>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <div class="flip-back-top">
                                    <div class="back-thumb w-100">
                                        <img class="w-100 radius-10" src="{{ asset('assets/images/flip/kindergarten-01-back.jpg') }}" alt="card-icon">
                                    </div>
                                    <p>Babies enjoy classrooms made for exploring with teachers who support today’s big milestones.</p>
                                </div>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox variation-2">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-2">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="front-thumb w-100">
                                    <img src="{{ asset('assets/images/flip/kindergarten-02-front.jpg') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Toddler / Twos</a></h5>
                                    <ul class="rbt-list-style-3">
                                        <li><i class="feather-heart"></i> Health and Wellness</li>
                                        <li><i class="feather-flag"></i> Literacy and Language</li>
                                        <li><i class="feather-eye"></i> Social-Emotional Learning</li>
                                        <li><i class="feather-edit-2"></i> Visual and Creative Arts
                                        </li>
                                        <li><i class="feather-battery-charging"></i> Thinking and Learning</li>
                                    </ul>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <div class="flip-back-top">
                                    <div class="back-thumb w-100">
                                        <img class="w-100 radius-10" src="{{ asset('assets/images/flip/kindergarten-02-back.jpg') }}" alt="card-icon">
                                    </div>
                                    <p>Babies enjoy classrooms made for exploring with teachers who support today’s big milestones.</p>
                                </div>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox variation-2">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-3">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="front-thumb w-100">
                                    <img src="{{ asset('assets/images/flip/kindergarten-03-front.jpg') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Preschool</a></h5>
                                    <ul class="rbt-list-style-3">
                                        <li><i class="feather-heart"></i> Health and Wellness</li>
                                        <li><i class="feather-flag"></i> Literacy and Language</li>
                                        <li><i class="feather-eye"></i> Social-Emotional Learning</li>
                                        <li><i class="feather-edit-2"></i> Visual and Creative Arts
                                        </li>
                                        <li><i class="feather-battery-charging"></i> Thinking and Learning</li>
                                    </ul>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <div class="flip-back-top">
                                    <div class="back-thumb w-100">
                                        <img class="w-100 radius-10" src="{{ asset('assets/images/flip/kindergarten-03-back.jpg') }}" alt="card-icon">
                                    </div>
                                    <p>Babies enjoy classrooms made for exploring with teachers who support today’s big milestones.</p>
                                </div>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="rbt-flipbox variation-2">
                        <div class="rbt-flipbox-wrap rbt-service rbt-service-1 card-bg-4">
                            <div class="rbt-flipbox-front rbt-flipbox-face inner">
                                <div class="front-thumb w-100">
                                    <img src="{{ asset('assets/images/flip/kindergarten-04-front.jpg') }}" alt="card-icon">
                                </div>
                                <div class="content">
                                    <h5 class="title"><a href="#">Kindergarten Prep</a></h5>
                                    <ul class="rbt-list-style-3">
                                        <li><i class="feather-heart"></i> Health and Wellness</li>
                                        <li><i class="feather-flag"></i> Literacy and Language</li>
                                        <li><i class="feather-eye"></i> Social-Emotional Learning</li>
                                        <li><i class="feather-edit-2"></i> Visual and Creative Arts
                                        </li>
                                        <li><i class="feather-battery-charging"></i> Thinking and Learning</li>
                                    </ul>
                                    <a class="rbt-btn-link stretched-link" href="#">Learn More<i class="feather-arrow-right"></i></a>
                                </div>
                            </div>

                            <div class="rbt-flipbox-back rbt-flipbox-face inner">
                                <div class="flip-back-top">
                                    <div class="back-thumb w-100">
                                        <img class="w-100 radius-10" src="{{ asset('assets/images/flip/kindergarten-04-back.jpg') }}" alt="card-icon">
                                    </div>
                                    <p>Babies enjoy classrooms made for exploring with teachers who support today’s big milestones.</p>
                                </div>
                                <a class="rbt-btn rbt-switch-btn btn-white btn-sm" href="#">
                                    <span data-text="Learn More">Learn More</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

            </div>
        </div>
    </div>
    <!-- End Service Area -->

    <!-- Start Service Area -->
    <div class="rbt-rbt-card-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="title">Style Twelve.</h2>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/001-bulb.png') }}" alt="icons Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Your Apply</a></h6>
                                <p class="description">English Learning looking for random paragraphs, you've come to the right place.</p>
                            </div>
                            <span class="number-text">1</span>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/002-hat.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">We Connect</a></h6>
                                <p class="description">Javascript Learning looking for random paragraphs, you've come to the right place.</p>
                            </div>
                            <span class="number-text">2</span>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/003-id-card.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">You Get Ready</a></h6>
                                <p class="description">Angular Learning looking for random paragraphs, you've come to the right place.</p>
                            </div>
                            <span class="number-text">3</span>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

                <!-- Start Service Grid  -->
                <div class="col-lg-4 col-xl-3 col-xxl-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6">
                        <div class="inner">
                            <div class="icon">
                                <img src="{{ asset('assets/images/icons/004-pass.png') }}" alt="Shape Images">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Completed</a></h6>
                                <p class="description">Php Learning looking for random paragraphs, you've come to the right place.</p>
                            </div>
                            <span class="number-text">4</span>
                        </div>
                    </div>
                </div>
                <!-- End Service Grid  -->

            </div>
        </div>
    </div>
    <!-- End Service Area -->

@endsection
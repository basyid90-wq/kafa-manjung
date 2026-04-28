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
                        <h2 class="title">Instructor</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="#">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Instructor</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="rbt-team-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--50">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Carousel Style).</h5>
                        <p class="description mt--10">Awesome Carousel Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-5">

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-05.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-07.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-04.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-06.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-08.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-10.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

            </div>

            <div class="rbt-team-modal modal fade rbt-modal-default" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="feather-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="inner">
                                <div class="row g-5 row--30 align-items-center">
                                    <div class="col-lg-4">
                                        <div class="rbt-team-thumbnail">
                                            <div class="thumb">
                                                <img class="w-100" src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Testimonial Images">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="rbt-team-details">
                                            <div class="author-info">
                                                <h4 class="title">Mames Mary</h4>
                                                <span class="designation theme-gradient">English Teacher</span>
                                                <span class="team-form">
                                        <i class="feather-map-pin"></i>
                                        <span class="location">CO Miego, AD,USA</span>
                                                </span>
                                            </div>
                                            <p class="mb--15">You can run Histudy easily. Any School, University, College can be use this histudy education template for their educational purpose. A university can be success you.</p>

                                            <p>Run their online leaning management system by histudy education template any where and time.</p>
                                            <ul class="social-icon social-default mt--20 justify-content-start">
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
                                                <li>
                                                    <a href="https://www.linkdin.com/">
                                                        <i class="feather-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="rbt-information-list mt--25">
                                                <li>
                                                    <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                                </li>
                                                <li>
                                                    <a href="mailto:hello@example.com"><i
                                                class="feather-mail"></i>example@gmail.com</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="top-circle-shape"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-white rbt-section-gapBottom">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Carousel Style).</h5>
                        <p class="description mt--10">Awesome Carousel Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-5">

                <div class="col-lg-7">
                    <!-- Start Tab Content  -->
                    <div class="rbt-team-tab-content tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="team-tab1" role="tabpanel" aria-labelledby="team-tab1-tab">
                            <div class="inner">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                                <div class="rbt-team-details">
                                    <div class="author-info">
                                        <h4 class="title">Mames Mary</h4>
                                        <span class="designation theme-gradient">English Teacher</span>
                                        <span class="team-form">
                                <i class="feather-map-pin"></i>
                                <span class="location">CO Miego, AD,USA</span>
                                        </span>
                                    </div>
                                    <p>Histudy The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="social-icon social-default mt--20 justify-content-start">
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
                                    </ul>
                                    <ul class="rbt-information-list mt--25">
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="team-tab2" role="tabpanel" aria-labelledby="team-tab2-tab">
                            <div class="inner">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                                <div class="rbt-team-details">
                                    <div class="author-info">
                                        <h4 class="title">Robert Song</h4>
                                        <span class="designation theme-gradient">Math Teacher</span>
                                        <span class="team-form">
                                <i class="feather-map-pin"></i>
                                <span class="location">CO Miego, AD,USA</span>
                                        </span>
                                    </div>
                                    <p>Education The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="social-icon social-default mt--20 justify-content-start">
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
                                    </ul>
                                    <ul class="rbt-information-list mt--25">
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="team-tab3" role="tabpanel" aria-labelledby="team-tab3-tab">
                            <div class="inner">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                                <div class="rbt-team-details">
                                    <div class="author-info">
                                        <h4 class="title">William Susan</h4>
                                        <span class="designation theme-gradient">React Teacher</span>
                                        <span class="team-form">
                                <i class="feather-map-pin"></i>
                                <span class="location">CO Miego, AD,USA</span>
                                        </span>
                                    </div>
                                    <p>React The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="social-icon social-default mt--20 justify-content-start">
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
                                    </ul>
                                    <ul class="rbt-information-list mt--25">
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="team-tab4" role="tabpanel" aria-labelledby="team-tab4-tab">
                            <div class="inner">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-04.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                                <div class="rbt-team-details">
                                    <div class="author-info">
                                        <h4 class="title">Soseph Sara</h4>
                                        <span class="designation theme-gradient">Web Teacher</span>
                                        <span class="team-form">
                                <i class="feather-map-pin"></i>
                                <span class="location">CO Miego, AD,USA</span>
                                        </span>
                                    </div>
                                    <p>Histudy The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="social-icon social-default mt--20 justify-content-start">
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
                                    </ul>
                                    <ul class="rbt-information-list mt--25">
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="team-tab5" role="tabpanel" aria-labelledby="team-tab5-tab">
                            <div class="inner">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-05.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                                <div class="rbt-team-details">
                                    <div class="author-info">
                                        <h4 class="title">Thomas Dal</h4>
                                        <span class="designation theme-gradient">Graphic Teacher</span>
                                        <span class="team-form">
                                <i class="feather-map-pin"></i>
                                <span class="location">CO Miego, AD,USA</span>
                                        </span>
                                    </div>
                                    <p>Histudy The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="social-icon social-default mt--20 justify-content-start">
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
                                    </ul>
                                    <ul class="rbt-information-list mt--25">
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="team-tab6" role="tabpanel" aria-labelledby="team-tab6-tab">
                            <div class="inner">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-06.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                                <div class="rbt-team-details">
                                    <div class="author-info">
                                        <h4 class="title">Christopher Lisa</h4>
                                        <span class="designation theme-gradient">English Teacher</span>
                                        <span class="team-form">
                                <i class="feather-map-pin"></i>
                                <span class="location">CO Miego, AD,USA</span>
                                        </span>
                                    </div>
                                    <p>Histudy The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</p>
                                    <ul class="social-icon social-default mt--20 justify-content-start">
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
                                    </ul>
                                    <ul class="rbt-information-list mt--25">
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                        </li>
                                        <li>
                                            <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="top-circle-shape"></div>
                    </div>
                    <!-- End Tab Content  -->
                </div>

                <div class="col-lg-5">
                    <!-- Start Tab Nav  -->
                    <ul class="rbt-team-tab-thumb nav nav-tabs" id="myTab" role="tablist">
                        <li>
                            <a class="active" id="team-tab1-tab" data-bs-toggle="tab" data-bs-target="#team-tab1" role="tab" aria-controls="team-tab1" aria-selected="true">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="team-tab2-tab" data-bs-toggle="tab" data-bs-target="#team-tab2" role="tab" aria-controls="team-tab2" aria-selected="false">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="team-tab3-tab" data-bs-toggle="tab" data-bs-target="#team-tab3" role="tab" aria-controls="team-tab3" aria-selected="false">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="team-tab4-tab" data-bs-toggle="tab" data-bs-target="#team-tab4" role="tab" aria-controls="team-tab4" aria-selected="false">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-04.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="team-tab5-tab" data-bs-toggle="tab" data-bs-target="#team-tab5" role="tab" aria-controls="team-tab5" aria-selected="false">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-05.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="team-tab6-tab" data-bs-toggle="tab" data-bs-target="#team-tab6" role="tab" aria-controls="team-tab6" aria-selected="false">
                                <div class="rbt-team-thumbnail">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/team/team-06.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <!-- End Tab Content  -->
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-white rbt-section-gapBottom">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Modern).</h5>
                        <p class="description mt--10">Modern Circle Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default rbt-hover-02">
                        <div class="inner">
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Corporate Template">
                            </div>
                            <div class="content">
                                <h2 class="title">Irma J. Erwin</h2>
                                <h6 class="subtitle theme-gradient">Master's Degree</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                                <p class="description">Yes, I am a Teacher. I have a passion for
                                    teaching student.</p>
                                <ul class="social-icon social-default icon-naked mt--20">
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default rbt-hover-02">
                        <div class="inner">
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Corporate Template">
                            </div>
                            <div class="content">
                                <h2 class="title">Irma J. Erwin</h2>
                                <h6 class="subtitle theme-gradient">Master's Degree</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                                <p class="description">Yes, I am a Teacher. I have a passion for
                                    teaching student.</p>
                                <ul class="social-icon social-default icon-naked mt--20">
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
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default rbt-hover-02">
                        <div class="inner">
                            <div class="thumbnail">
                                <img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Corporate Template">
                            </div>
                            <div class="content">
                                <h2 class="title">Irma J. Erwin</h2>
                                <h6 class="subtitle theme-gradient">Master's Degree</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                                <p class="description">Yes, I am a Teacher. I have a passion for
                                    teaching student.</p>
                                <ul class="social-icon social-default icon-naked mt--20">
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
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Single Team  -->
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Standard).</h5>
                        <p class="description mt--10">Standard Image Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default style-three rbt-hover">
                        <div class="inner">
                            <div class="thumbnail"><img src="{{ asset('assets/images/team/team-07.jpg') }}" alt="Corporate Template"></div>
                            <div class="content">
                                <h2 class="title">Alejandro</h2>
                                <h6 class="subtitle theme-gradient">Math Teacher</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default style-three rbt-hover">
                        <div class="inner">
                            <div class="thumbnail"><img src="{{ asset('assets/images/team/team-08.jpg') }}" alt="Corporate Template"></div>
                            <div class="content">
                                <h2 class="title">John Due</h2>
                                <h6 class="subtitle theme-gradient">Depertment Head</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default style-three rbt-hover">
                        <div class="inner">
                            <div class="thumbnail"><img src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Corporate Template"></div>
                            <div class="content">
                                <h2 class="title">Joo Bieden</h2>
                                <h6 class="subtitle theme-gradient">Math Teacher</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--30">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Card Box).</h5>
                        <p class="description mt--10">Card Box Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default style-two rbt-hover">
                        <div class="inner">
                            <div class="thumbnail"><img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Corporate Template"></div>
                            <div class="content">
                                <h2 class="title">Alejandro</h2>
                                <h6 class="subtitle theme-gradient">Math Teacher</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                                <p class="description">Yes, I am a Depertment Teacher. I have a passion for
                                    learning system.</p>
                                <ul class="social-icon social-default icon-naked mt--20">
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default style-two rbt-hover">
                        <div class="inner">
                            <div class="thumbnail"><img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Corporate Template"></div>
                            <div class="content">
                                <h2 class="title">Alejandro</h2>
                                <h6 class="subtitle theme-gradient">Math Teacher</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                                <p class="description">Yes, I am a Depertment Teacher. I have a passion for
                                    learning system.</p>
                                <ul class="social-icon social-default icon-naked mt--20">
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="rbt-team team-style-default style-two rbt-hover">
                        <div class="inner">
                            <div class="thumbnail"><img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Corporate Template"></div>
                            <div class="content">
                                <h2 class="title">Alejandro</h2>
                                <h6 class="subtitle theme-gradient">Math Teacher</h6>
                                <span class="team-form">
                        <i class="feather-map-pin"></i>
                        <span class="location">CO Miego, AD,USA</span>
                                </span>
                                <p class="description">Yes, I am a Depertment Teacher. I have a passion for
                                    learning system.</p>
                                <ul class="social-icon social-default icon-naked mt--20">
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
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Team  -->
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Hover Style).</h5>
                        <p class="description mt--10">Awesome Hover Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="team">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-05.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">Aaron Griffin</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="team">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">Rafiq Bali</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="team">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">Fatima Usa</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="team">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-07.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">John Due</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Hover Bottom Content).</h5>
                        <p class="description mt--10">Awesome Hover Bottom Content.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row row--15 mt_dec--30">
                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="team team-style--bottom">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-10.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">Aaron M. Griffin</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="team team-style--bottom">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">Aaron M. Griffin</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-4 col-md-6 col-12 mt--30">
                    <div class="team team-style--bottom">
                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-08.jpg') }}" alt="Blog Images">
                        </div>
                        <div class="content">
                            <h4 class="title">Aaron M. Griffin</h4>
                            <p class="designation">Depertment Head</p>
                        </div>
                        <ul class="social-icon">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Team  -->

            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row mb--55">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Carousel Style).</h5>
                        <p class="description mt--10">Awesome Carousel Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row row--15">
                <div class="col-lg-12">
                    <div class="swiper team-slide-activation rbt-arrow-between rbt-dot-bottom-center">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="team team-style--bottom variation-2">
                                    <div class="thumbnail">
                                        <a href="#"><img src="{{ asset('assets/images/team/team-04.jpg') }}" alt="Blog Images"></a>
                                    </div>
                                    <div class="content">
                                        <div class="inner">
                                            <h4 class="title"><a href="#">Aaron M. Griffin</a></h4>
                                            <p class="designation">Depertment Head</p>
                                        </div>
                                        <div class="icon-right">
                                            <a href="#"><i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="team team-style--bottom variation-2">
                                    <div class="thumbnail">
                                        <a href="#"><img src="{{ asset('assets/images/team/team-05.jpg') }}" alt="Blog Images"></a>
                                    </div>
                                    <div class="content">
                                        <div class="inner">
                                            <h4 class="title"><a href="#">John Due</a></h4>
                                            <p class="designation">Depertment Head</p>
                                        </div>
                                        <div class="icon-right">
                                            <a href="#"><i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="team team-style--bottom variation-2">
                                    <div class="thumbnail">
                                        <a href="#"><img src="{{ asset('assets/images/team/team-06.jpg') }}" alt="Blog Images"></a>
                                    </div>
                                    <div class="content">
                                        <div class="inner">
                                            <h4 class="title"><a href="#">Griffin DM</a></h4>
                                            <p class="designation">Depertment Head</p>
                                        </div>
                                        <div class="icon-right">
                                            <a href="#"><i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="team team-style--bottom variation-2">
                                    <div class="thumbnail">
                                        <a href="#"><img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Blog Images"></a>
                                    </div>
                                    <div class="content">
                                        <div class="inner">
                                            <h4 class="title"><a href="#">Aaron M. Griffin</a></h4>
                                            <p class="designation">Depertment Head</p>
                                        </div>
                                        <div class="icon-right">
                                            <a href="#"><i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="team team-style--bottom variation-2">
                                    <div class="thumbnail">
                                        <a href="#"><img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Blog Images"></a>
                                    </div>
                                    <div class="content">
                                        <div class="inner">
                                            <h4 class="title"><a href="#">Aaron M. Griffin</a></h4>
                                            <p class="designation">Depertment Head</p>
                                        </div>
                                        <div class="icon-right">
                                            <a href="#"><i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="team team-style--bottom variation-2">
                                    <div class="thumbnail">
                                        <a href="#"><img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Blog Images"></a>
                                    </div>
                                    <div class="content">
                                        <div class="inner">
                                            <h4 class="title"><a href="#">Aaron M. Griffin</a></h4>
                                            <p class="designation">Depertment Head</p>
                                        </div>
                                        <div class="icon-right">
                                            <a href="#"><i class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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


                        <div class="rbt-swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h5 class="title">Team (Carousel Style).</h5>
                        <p class="description mt--10">Awesome Carousel Style.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper team-slide-activation-2 rbt-dot-bottom-center ptb--50">
                        <div class="swiper-wrapper">
                            <!-- Start Single Team  -->
                            <div class="swiper-slide">
                                <div class="rbt-team team-style-default style-three rbt-hover">
                                    <div class="inner">
                                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-07.jpg') }}" alt="Corporate Template"></div>
                                        <div class="content">
                                            <h2 class="title">Alejandro</h2>
                                            <h6 class="subtitle theme-gradient">Math Teacher</h6>
                                            <span class="team-form">
                                                <i class="feather-map-pin"></i>
                                                <span class="location">CO Miego, AD,USA</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Team  -->

                            <!-- Start Single Team  -->
                            <div class="swiper-slide">
                                <div class="rbt-team team-style-default style-three rbt-hover">
                                    <div class="inner">
                                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-08.jpg') }}" alt="Corporate Template"></div>
                                        <div class="content">
                                            <h2 class="title">John Due</h2>
                                            <h6 class="subtitle theme-gradient">Depertment Head</h6>
                                            <span class="team-form">
                                                <i class="feather-map-pin"></i>
                                                <span class="location">CO Miego, AD,USA</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Team  -->

                            <!-- Start Single Team  -->
                            <div class="swiper-slide">
                                <div class="rbt-team team-style-default style-three rbt-hover">
                                    <div class="inner">
                                        <div class="thumbnail"><img src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Corporate Template"></div>
                                        <div class="content">
                                            <h2 class="title">Joo Bieden</h2>
                                            <h6 class="subtitle theme-gradient">English Teacher</h6>
                                            <span class="team-form">
                                                <i class="feather-map-pin"></i>
                                                <span class="location">CO Miego, AD,USA</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Team  -->
                        </div>
                        <div class="rbt-swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-team-area bg-gradient-8 rbt-section-gap">
        <div class="container">
            <div class="row mb--60 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-white-opacity">Our Instructor</span>
                        <h2 class="title color-white">Expert Instructor</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="read-more-btn text-start text-md-end">
                        <a class="rbt-btn hover-icon-reverse radius-round btn-white" href="#">
                            <div class="icon-reverse-wrapper">
                                <span class="btn-text">BECAME A INSTRUCTOR</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row g-5">

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-05.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-03.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-07.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-01.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-02.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-04.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-06.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-08.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

                <!-- Start Single Team  -->
                <div class="col-lg-2 col-md-3 col-sm-4 col-12">
                    <div class="rbt-team-modal-thumb nav nav-tabs">
                        <a class="rbt-team-thumbnail" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="thumb">
                                <img src="{{ asset('assets/images/team/team-10.jpg') }}" alt="Testimonial Images">
                            </div>
                        </a>
                    </div>
                </div>
                <!-- End Single Team  -->

            </div>

            <div class="rbt-team-modal modal fade rbt-modal-default" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="rbt-round-btn" data-bs-dismiss="modal" aria-label="Close">
                                <i class="feather-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="inner">
                                <div class="row g-5 row--30 align-items-center">
                                    <div class="col-lg-4">
                                        <div class="rbt-team-thumbnail">
                                            <div class="thumb">
                                                <img class="w-100" src="{{ asset('assets/images/team/team-09.jpg') }}" alt="Testimonial Images">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="rbt-team-details">
                                            <div class="author-info">
                                                <h4 class="title">Mames Mary</h4>
                                                <span class="designation theme-gradient">English Teacher</span>
                                                <span class="team-form">
                                        <i class="feather-map-pin"></i>
                                        <span class="location">CO Miego, AD,USA</span>
                                                </span>
                                            </div>
                                            <p class="mb--15">You can run Histudy easily. Any School, University, College can be use this histudy education template for their educational purpose. A university can be success you.</p>

                                            <p>Run their online leaning management system by histudy education template any where and time.</p>
                                            <ul class="social-icon social-default mt--20 justify-content-start">
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
                                                <li>
                                                    <a href="https://www.linkdin.com/">
                                                        <i class="feather-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="rbt-information-list mt--25">
                                                <li>
                                                    <a href="#"><i class="feather-phone"></i>+1-202-555-0174</a>
                                                </li>
                                                <li>
                                                    <a href="mailto:hello@example.com"><i
                                                class="feather-mail"></i>example@gmail.com</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="top-circle-shape"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-separator/>
    
@endsection
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
                        <h2 class="title">Testimonial</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="#">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Testimonial</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="rbt-testimonial-area bg-color-white rbt-section-gap overflow-hidden">
        <div class="container">
            <div class="row align-items-center row--30">
                <div class="col-lg-6">
                    <!-- Start Tab Content  -->
                    <div class="rbt-testimonial-content tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="testimonial-tab1" role="tabpanel" aria-labelledby="testimonial-tab1-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Histudy The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Histudy </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab2" role="tabpanel" aria-labelledby="testimonial-tab2-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Nira </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab3" role="tabpanel" aria-labelledby="testimonial-tab3-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Rafiq The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Jone Jane </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab4" role="tabpanel" aria-labelledby="testimonial-tab4-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Janen The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Janen Asrafy </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab5" role="tabpanel" aria-labelledby="testimonial-tab5-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Afrin The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Afrin </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab6" role="tabpanel" aria-labelledby="testimonial-tab6-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Education The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Asrafy </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab7" role="tabpanel" aria-labelledby="testimonial-tab7-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Mohima The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Mohima Asrafy </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="testimonial-tab8" role="tabpanel" aria-labelledby="testimonial-tab8-tab">
                            <div class="inner">
                                <div class="rating mb--30">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                                <p>Nuha The standard chunk of Lorem Ipsum used since the 1500s is reproduced
                                    below for those interested. Sections Bonorum et Malorum original.</p>
                            </div>
                            <div class="author-info">
                                <h6><span>Nuha </span> - COO, AMERIMAR ENTERPRISES, INC.</h6>
                            </div>
                        </div>
                    </div>
                    <!-- End Tab Content  -->
                </div>
                <div class="col-lg-6 mt_md--30 mt_sm--30">
                    <!-- Start Tab Nav  -->
                    <ul class="testimonial-thumb-wrapper nav nav-tabs" id="myTab" role="tablist">
                        <li>
                            <a class="active" id="testimonial-tab1-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab1" role="tab" aria-controls="testimonial-tab1" aria-selected="true">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-1.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="testimonial-tab2-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab2" role="tab" aria-controls="testimonial-tab2" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-2.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="testimonial-tab3-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab3" role="tab" aria-controls="testimonial-tab3" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-3.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a id="testimonial-tab4-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab4" role="tab" aria-controls="testimonial-tab4" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-4.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="testimonial-tab5-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab5" role="tab" aria-controls="testimonial-tab5" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-5.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="testimonial-tab6-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab6" role="tab" aria-controls="testimonial-tab6" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-6.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="testimonial-tab7-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab7" role="tab" aria-controls="testimonial-tab7" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-7.jpg') }}" alt="Testimonial Images">
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a id="testimonial-tab8-tab" data-bs-toggle="tab" data-bs-target="#testimonial-tab8" role="tab" aria-controls="testimonial-tab8" aria-selected="false">
                                <div class="testimonial-thumbnai">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-8.jpg') }}" alt="Testimonial Images">
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

    <div class="rbt-testimonial-area bg-color-extra2 rbt-section-gap overflow-hidden">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                            <h2 class="title">People like histudy education. <br /> No joking - here’s the proof!</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-animation-wrapper mt--50">
            <div class="scroll-animation scroll-right-left">

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Martha Maldonado</h5>
                                    <span>Executive Chairman <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Michael D. Lovelady</h5>
                                    <span>CEO <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Valerie J. Creasman</h5>
                                    <span>Executive Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-04.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Hannah R. Sutton</h5>
                                    <span>Executive Chairman <i>@ Facebook</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">People says about, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Pearl B. Hill</h5>
                                    <span>Chairman SR <i>@ Facebook</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Like this histudy, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Mandy F. Wood</h5>
                                    <span>SR Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Mildred W. Diaz</h5>
                                    <span>Executive Officer <i>@ Yelp</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Christopher H. Win</h5>
                                    <span>Product Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Martha Maldonado</h5>
                                    <span>Executive Chairman <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
            </div>
        </div>

        <div class="scroll-animation-wrapper mt--30">
            <div class="scroll-animation scroll-left-right">

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Martha Maldonado</h5>
                                    <span>Executive Chairman <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Michael D. Lovelady</h5>
                                    <span>CEO <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Valerie J. Creasman</h5>
                                    <span>Executive Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-04.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Hannah R. Sutton</h5>
                                    <span>Executive Chairman <i>@ Facebook</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">People says about, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Pearl B. Hill</h5>
                                    <span>Chairman SR <i>@ Facebook</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Like this histudy, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Mandy F. Wood</h5>
                                    <span>SR Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Mildred W. Diaz</h5>
                                    <span>Executive Officer <i>@ Yelp</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Christopher H. Win</h5>
                                    <span>Product Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Martha Maldonado</h5>
                                    <span>Executive Chairman <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
            </div>
        </div>
    </div>

    <div class="rbt-testimonial-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb--60">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                        <h2 class="title">Student's Feedback</h2>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="rbt-accordion-style rbt-accordion-01  accordion">
                        <div class="accordion" id="accordionExamplea1">
                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        What is Histudy ? How does it work?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExamplea1">
                                    <div class="accordion-body card-body">
                                        You can run Histudy easily. Any School, University, College can be use this
                                        histudy education template for their educational purpose. A university can be
                                        run their online leaning management system by histudy education template.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How can I get the customer support?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExamplea1">
                                    <div class="accordion-body card-body">
                                        After purchasing the product need you any support you can be share with
                                        us with sending mail to pixcelsthemes@gmail.com.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item card">
                                <h2 class="accordion-header card-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Can I get update regularly and For how long do I get updates?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExamplea1">
                                    <div class="accordion-body card-body">
                                        Yes, We will get update the Histudy. And you can get it any time. Next
                                        time we will comes with more feature. You can be get update for
                                        unlimited times. Our dedicated team works for update.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="swiper testimonial-activation-1 rbt-dot-bottom-left pb--60">
                        <div class="swiper-wrapper">
                            <!-- Start Single Testimonial  -->
                            <div class="swiper-slide">
                                <div class="rbt-testimonial-box no-box-shadow bg-gray-light">
                                    <div class="inner">
                                        <div class="clint-info-wrapper">
                                            <div class="thumb">
                                                <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                            </div>
                                            <div class="client-info">
                                                <h5 class="title">Martha Maldonado</h5>
                                                <span>Executive Chairman <i>@ Google</i></span>
                                            </div>
                                        </div>
                                        <div class="description">
                                            <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                                auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                velit. Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text ever
                                                since the</p>
                                            <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                                    class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Testimonial  -->

                            <!-- Start Single Testimonial  -->
                            <div class="swiper-slide">
                                <div class="rbt-testimonial-box no-box-shadow bg-gray-light">
                                    <div class="inner">
                                        <div class="clint-info-wrapper">
                                            <div class="thumb">
                                                <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                            </div>
                                            <div class="client-info">
                                                <h5 class="title">Martha Maldonado</h5>
                                                <span>Executive Chairman <i>@ Google</i></span>
                                            </div>
                                        </div>
                                        <div class="description">
                                            <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                                auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                velit. Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text ever
                                                since the</p>
                                            <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                                    class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Testimonial  -->

                            <!-- Start Single Testimonial  -->
                            <div class="swiper-slide">
                                <div class="rbt-testimonial-box no-box-shadow bg-gray-light">
                                    <div class="inner">
                                        <div class="clint-info-wrapper">
                                            <div class="thumb">
                                                <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                            </div>
                                            <div class="client-info">
                                                <h5 class="title">Martha Maldonado</h5>
                                                <span>Executive Chairman <i>@ Google</i></span>
                                            </div>
                                        </div>
                                        <div class="description">
                                            <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                                auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                velit. Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the industry's standard dummy text ever
                                                since the</p>
                                            <a class="rbt-btn-link" href="#">Read Project Case Study<i
                                                    class="feather-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Testimonial  -->

                        </div>
                        <div class="rbt-swiper-pagination"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="rbt-testimonial-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb--60">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                        <h2 class="title">Student's Feedback</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <!-- Start Single Testimonial  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Martha Maldonado</h5>
                                    <span>Executive Chairman <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="rating mt--20">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Michael D. Lovelady</h5>
                                    <span>CEO <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                <div class="rating mt--20">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="rbt-testimonial-box">
                        <div class="inner">
                            <div class="clint-info-wrapper">
                                <div class="thumb">
                                    <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                </div>
                                <div class="client-info">
                                    <h5 class="title">Valerie J. Creasman</h5>
                                    <span>Executive Designer <i>@ Google</i></span>
                                </div>
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                <div class="rating mt--20">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
            </div>
        </div>
    </div>

    <div class="rbt-testimonial-area bg-color-extra2 rbt-section-gapBottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb--60">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                        <h2 class="title">Student's Feedback</h2>
                    </div>
                </div>
            </div>
            <div class="testimonial-item-3-activation swiper rbt-arrow-between gutter-swiper-30">
                <div class="swiper-wrapper">

                    <!-- Start Single Testimonial  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-testimonial-box">
                                <div class="inner bg-no-shadow bg-color-primary-opacity">
                                    <div class="clint-info-wrapper">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                        </div>
                                        <div class="client-info">
                                            <h5 class="title">Martha Maldonado</h5>
                                            <span>Executive Chairman <i>@ Google</i></span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                        <div class="rating mt--20">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial  -->

                    <!-- Start Single Testimonial  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-testimonial-box">
                                <div class="inner bg-no-shadow bg-color-primary-opacity">
                                    <div class="clint-info-wrapper">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                        </div>
                                        <div class="client-info">
                                            <h5 class="title">Michael D. Lovelady</h5>
                                            <span>CEO <i>@ Google</i></span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                        <div class="rating mt--20">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial  -->

                    <!-- Start Single Testimonial  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-testimonial-box">
                                <div class="inner bg-no-shadow bg-color-primary-opacity">
                                    <div class="clint-info-wrapper">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                        </div>
                                        <div class="client-info">
                                            <h5 class="title">Valerie J. Creasman</h5>
                                            <span>Executive Designer <i>@ Google</i></span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                        <div class="rating mt--20">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial  -->

                    <!-- Start Single Testimonial  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-testimonial-box">
                                <div class="inner bg-no-shadow bg-color-primary-opacity">
                                    <div class="clint-info-wrapper">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                        </div>
                                        <div class="client-info">
                                            <h5 class="title">Valerie J. Creasman</h5>
                                            <span>Executive Designer <i>@ Google</i></span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                        <div class="rating mt--20">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial  -->

                    <!-- Start Single Testimonial  -->
                    <div class="swiper-slide">
                        <div class="single-slide">
                            <div class="rbt-testimonial-box">
                                <div class="inner bg-no-shadow bg-color-primary-opacity">
                                    <div class="clint-info-wrapper">
                                        <div class="thumb">
                                            <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                        </div>
                                        <div class="client-info">
                                            <h5 class="title">Valerie J. Creasman</h5>
                                            <span>Executive Designer <i>@ Google</i></span>
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                            auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget.</p>
                                        <div class="rating mt--20">
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                            <a href="#"><i class="fa fa-star"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Testimonial  -->
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
        </div>
    </div>

    <div class="rbt-testimonial-area bg-color-white rbt-section-gap overflow-hidden">
        <div class="container-fluid">
            <div class="row g-5 align-items-center">
                <div class="col-xl-3">
                    <div class="section-title pl--100 pl_md--30 pl_sm--0">
                        <h2 class="title">What Our Learners Say</h2>
                        <p class="description mt--20">Learning communicate to global world and build a bright future with our histudy.</p>
                        <div class="veiw-more-btn mt--20">
                            <a class="rbt-btn btn-gradient rbt-marquee-btn marquee-text-y" href="#">
                                <span data-text="Marquee Y">
                                    Marquee Y
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="overflow-hidden">
                        <div class="scroll-animation-wrapper pt--50 pb--30">
                            <div class="scroll-animation scroll-right-left">

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Martha Maldonado</h5>
                                                    <span>Executive Chairman <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Michael D. Lovelady</h5>
                                                    <span>CEO <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Valerie J. Creasman</h5>
                                                    <span>Executive Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-04.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Hannah R. Sutton</h5>
                                                    <span>Executive Chairman <i>@ Facebook</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">People says about, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->
                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Pearl B. Hill</h5>
                                                    <span>Chairman SR <i>@ Facebook</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Like this histudy, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Mandy F. Wood</h5>
                                                    <span>SR Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Mildred W. Diaz</h5>
                                                    <span>Executive Officer <i>@ Yelp</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Christopher H. Win</h5>
                                                    <span>Product Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Martha Maldonado</h5>
                                                    <span>Executive Chairman <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->
                            </div>
                        </div>
                        <div class="scroll-animation-wrapper pb--50">
                            <div class="scroll-animation scroll-left-right">

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Martha Maldonado</h5>
                                                    <span>Executive Chairman <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Christopher H. Win</h5>
                                                    <span>Product Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Mildred W. Diaz</h5>
                                                    <span>Executive Officer <i>@ Yelp</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Mandy F. Wood</h5>
                                                    <span>SR Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Pearl B. Hill</h5>
                                                    <span>Chairman SR <i>@ Facebook</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Like this histudy, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Mandy F. Wood</h5>
                                                    <span>SR Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Mildred W. Diaz</h5>
                                                    <span>Executive Officer <i>@ Yelp</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Christopher H. Win</h5>
                                                    <span>Product Designer <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->

                                <!-- Start Single Testimonial  -->
                                <div class="single-column-20">
                                    <div class="rbt-testimonial-box">
                                        <div class="inner">
                                            <div class="clint-info-wrapper">
                                                <div class="thumb">
                                                    <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                                </div>
                                                <div class="client-info">
                                                    <h5 class="title">Martha Maldonado</h5>
                                                    <span>Executive Chairman <i>@ Google</i></span>
                                                </div>
                                            </div>
                                            <div class="description">
                                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus
                                                    velit.</p>
                                                <div class="rating mt--20">
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                    <a href="#"><i class="fa fa-star"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Testimonial  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-testimonial-area bg-color-white rbt-section-gapBottom overflow-hidden">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                            <h2 class="title">People like histudy education. <br /> No joking - here’s the proof!</h2>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-animation-wrapper no-overlay mt--50">
            <div class="scroll-animation scroll-right-left">

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Martha Maldonado, <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/google.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Michael D., <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/yelp.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Valerie J., <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">People says about, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-04.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Hannah R., <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/bing.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Like this histudy, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Pearl B. Hill, <span>Marketing</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Mandy F. Wood, <span>SR Designer</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/hubs.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Mildred W. Diaz, <span>Executive</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/bing.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Christopher, <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-odd">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/yelp.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Fatima, <span>Child</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
            </div>
        </div>

        <div class="scroll-animation-wrapper no-overlay mt--30">
            <div class="scroll-animation scroll-left-right">

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">After the launch, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Martha Maldonado, <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/google.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Histudy education, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-02.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Michael D., <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/yelp.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Our educational, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-03.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Valerie J., <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/bing.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">People says about, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-04.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Hannah R., <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/hubs.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Like this histudy, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Pearl B. Hill, <span>Marketing</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/yelp.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Educational template, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-01.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Mandy F. Wood, <span>SR Designer</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/bing.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Online leaning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-07.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Mildred W. Diaz, <span>Executive</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/facebook.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">Remote learning, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-08.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Christopher, <span>CEO</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->

                <!-- Start Single Testimonial  -->
                <div class="single-column-20 bg-theme-gradient-even">
                    <div class="rbt-testimonial-box style-2">
                        <div class="inner">
                            <div class="icons">
                                <img src="{{ asset('assets/images/icons/yelp.png') }}" alt="Clint Images">
                            </div>
                            <div class="description">
                                <p class="subtitle-3">University managemnet, vulputate at sapien sit amet,
                                    auctor iaculis lorem. In vel hend rerit nisi. Vestibulum eget risus velit.</p>
                                <div class="clint-info-wrapper">
                                    <div class="thumb">
                                        <img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="Clint Images">
                                    </div>
                                    <div class="client-info">
                                        <h5 class="title">Fatima, <span>Child</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Testimonial  -->
            </div>
        </div>
    </div>

    <!-- Start Call To Action  -->
    <x-callToAction/>
    <!-- End Call To Action  -->

@endsection
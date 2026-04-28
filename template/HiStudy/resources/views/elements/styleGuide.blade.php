@extends('layout.layout')

@php
     $footer='true';
     $bodyClass='';
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
                        <h2 class="title">Style Guide</h2>
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="#">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">Style Guide</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->

    <div class="rbt-style-guide-area rbt-section-gap">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3">
                    <div class="rbt-default-sidebar sticky-top rbt-shadow-box rbt-gradient-border">
                        <div class="inner">
                            <div class="content-item-content">
                                <div class="rbt-widget-details">
                                    <nav class="onepagenav">
                                        <ul class="mainmenu rbt-course-details-list-wrapper">
                                            <li class="current"><a href="#colorPalette"><span>1. Color
                                                        Palette</span></a></li>
                                            <li class="current"><a href="#colordarkPalette"><span>2. Color
                                                        Dark Palette</span></a></li>
                                            <li><a href="#gradient"><span>3. Color Gradient</span></a></li>
                                            <li><a href="#typography"><span>4. Typography</span></a></li>
                                            <li><a href="#formElements"><span>5. Form Elements</span></a></li>
                                            <li><a href="#pagination"><span>6. Pagination</span></a></li>
                                            <li><a href="#tooltips"><span>7. Tooltips</span></a></li>
                                            <li><a href="#avatars"><span>8. Avatars</span></a></li>
                                            <li><a href="#animatedHeading"><span>9. Animated Heading</span></a></li>
                                            <li><a href="#rbtBorderRadius"><span>10. Border Radius</span></a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">

                    <div id="colorPalette" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Color Palette</h4>
                            </div>

                            <div class="row g-5">

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#2f57ef</span>
                                            <h6 class="title mb--0">Primary Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-secondary radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#b966e7</span>
                                            <h6 class="title mb--0">Secondary Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-coral radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#E9967A</span>
                                            <h6 class="title mb--0">Coral Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-violet radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#800080</span>
                                            <h6 class="title mb--0">Violet Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-pink radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#DB7093</span>
                                            <h6 class="title mb--0">pink Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-heading radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#192335</span>
                                            <h6 class="title mb--0">heading Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-body radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#6b7385</span>
                                            <h6 class="title mb--0">body Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-white radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#ffffff</span>
                                            <h6 class="title mb--0">white Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-white-off radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#FFFFFFAB</span>
                                            <h6 class="title mb--0">white off Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-bodyest radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#273041</span>
                                            <h6 class="title mb--0">bodyest Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-dark radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#27272E</span>
                                            <h6 class="title mb--0">dark Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-darker radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#192335</span>
                                            <h6 class="title mb--0">darker Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-black radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#111113</span>
                                            <h6 class="title mb--0">black Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-grey radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">rgba(207,207,207,.24</span>
                                            <h6 class="title mb--0">grey Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-grey2 radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#f4f5f7</span>
                                            <h6 class="title mb--0">grey2 Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-gray radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#A1A9AC</span>
                                            <h6 class="title mb--0">gray Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-gray-light radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#F6F6F6</span>
                                            <h6 class="title mb--0">gray light Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-gray-lighter radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#ebebeb</span>
                                            <h6 class="title mb--0">gray lighter Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-light radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#F5F7FA</span>
                                            <h6 class="title mb--0">light Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-lighter radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#F2F5F9</span>
                                            <h6 class="title mb--0">lighter Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#2f57ef21</span>
                                            <h6 class="title mb--0">primary opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-secondary-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#b966e721</span>
                                            <h6 class="title mb--0">secondary opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-coral-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#E9967A21</span>
                                            <h6 class="title mb--0">coral opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-violet-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#80008021</span>
                                            <h6 class="title mb--0">violet opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-pink-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#DB709321</span>
                                            <h6 class="title mb--0">pink opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-white-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#ffffff21</span>
                                            <h6 class="title mb--0">white opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-danger-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#FF000310</span>
                                            <h6 class="title mb--0">danger opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-warning-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#FF8F3C10</span>
                                            <h6 class="title mb--0">warning opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-black-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">rgba(0, 0, 0, 0.04)</span>
                                            <h6 class="title mb--0">black opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-heading-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#19233550</span>
                                            <h6 class="title mb--0">heading opacity Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box card-bg-1 radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#fffccf</span>
                                            <h6 class="title mb--0">Card Color 01</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box card-bg-2 radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#ffedff</span>
                                            <h6 class="title mb--0">Card Color 02</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box card-bg-3 radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#ffe8eb</span>
                                            <h6 class="title mb--0">Card Color 03</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box card-bg-4 radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#e9f6ff</span>
                                            <h6 class="title mb--0">Card Color 04</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-success radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#3EB75E</span>
                                            <h6 class="title mb--0">success Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-danger radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#FF0003</span>
                                            <h6 class="title mb--0">danger Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-warning radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#FF8F3C</span>
                                            <h6 class="title mb--0">warning Color</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-info radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#1BA2DB</span>
                                            <h6 class="title mb--0">info Color</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="colordarkPalette" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Color Dark Palette</h4>
                            </div>

                            <div class="row g-5">
                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box color-white-dark radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#D9D9D9</span>
                                            <h6 class="title mb--0">White Dark</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box color-bodyest radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#273041</span>
                                            <h6 class="title mb--0">Color Bodyest</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box color-bodyest-2 radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#324059b3</span>
                                            <h6 class="title mb--0">Color Bodyest 2</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box color-bodyest-opacity radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#2730415e</span>
                                            <h6 class="title mb--0">Color Bodyest Opacity</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-dark radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#27272E</span>
                                            <h6 class="title mb--0">Color Dark</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-darker radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2">#192335</span>
                                            <h6 class="title mb--0">Color Darker</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-14 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 1</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box gradient-dark radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 2</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="gradient" class="rbt-elements-color bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">

                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Color Gradient</h4>
                            </div>

                            <div class="row g-5">

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-1 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 1</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-2 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 2</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-3 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 3</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-4 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 4</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-5 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 5</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-6 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 6</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-7 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 7</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-8 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 8</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-9 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 9</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-10 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 10</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-11 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 11</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-12 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 12</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-gradient-13 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 13</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box gradient-dark-2 radius-10"></div>
                                        <div class="content mt--10">
                                            <h6 class="title mb--0">Gradient 16</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div id="typography" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Typography</h4>
                            </div>

                            <div class="row g-5">
                                <div class="col-lg-6">
                                    <h1>h1. Heading One</h1>
                                    <h2>h2. Heading Two</h2>
                                    <h3>h3. Heading Three</h3>
                                    <h4>h4. Heading Four</h4>
                                    <h5>h5. Heading Five</h5>
                                    <h6>h6. Heading Six</h6>
                                </div>
                                <div class="col-lg-6">
                                    <p class="b1">B1- Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                        Similique non ipsam reiciendis.</p>
                                    <p class="b2">B2- Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                        Similique non ipsam reiciendis.</p>
                                    <p class="b3">B3- Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                                        Similique non ipsam reiciendis.</p>
                                    <p>Befault- Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique non
                                        ipsam reiciendis.</p>
                                </div>
                            </div>

                            <div class="row mt--40">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">Heading Style</h4>
                                </div>
                                <div class="col-lg-12">
                                    <div class="section-title text-center">
                                        <h2 class="title">Heading Style One.</h2>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt--60">
                                    <div class="section-title text-center">
                                        <h2 class="rbt-title-style-2">Heading Style Two.</h2>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt--60">
                                    <div class="section-title text-center">
                                        <h2 class="rbt-title-style-3">Heading Style Three.</h2>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt--60">
                                    <div class="section-title text-center">
                                        <h2 class="rbt-short-title">Heading Short Title.</h2>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="formElements" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Form Elements</h4>
                            </div>
                            <div class="row g-5">

                                <div class="col-lg-6">
                                    <h5>Input</h5>
                                    <div class="form-group">
                                        <input name="con_name" type="text">
                                        <label>Name</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h5>Password</h5>
                                    <div class="form-group">
                                        <input name="con_password" type="password">
                                        <label>Password</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <h5>Textarea</h5>
                                    <div class="form-group">
                                        <textarea></textarea>
                                        <label>Textarea</label>
                                        <span class="focus-border"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h5>Checkbox</h5>
                                    <p class="rbt-checkbox-wrapper mb--5">
                                        <input id="rbt-checkbox-1" name="rbt-checkbox-1" type="checkbox" value="yes">
                                        <label for="rbt-checkbox-1">Option One</label>
                                    </p>
                                    <p class="rbt-checkbox-wrapper">
                                        <input id="rbt-checkbox-2" name="rbt-checkbox-2" type="checkbox" value="yes">
                                        <label for="rbt-checkbox-2">Option Two</label>
                                    </p>
                                </div>

                                <div class="col-lg-6">
                                    <h5>Radio</h5>
                                    <div class="rbt-form-check">
                                        <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-1">
                                        <label class="form-check-label" for="rbt-radio-1"> Option One</label>
                                    </div>
                                    <div class="rbt-form-check">
                                        <input class="form-check-input" type="radio" name="rbt-radio" id="rbt-radio-2">
                                        <label class="form-check-label" for="rbt-radio-2"> Option Two</label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h5>Disabled Checkbox</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDisabled" disabled>
                                        <label class="form-check-label" for="flexCheckDisabled">
                                            Disabled checkbox
                                        </label>
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <h5>Disabled Radio</h5>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioDisabled" disabled>
                                        <label class="form-check-label" for="flexRadioDisabled">
                                            Disabled radio
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioCheckedDisabled" checked disabled>
                                        <label class="form-check-label" for="flexRadioCheckedDisabled">
                                            Disabled checked radio
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h5>Default switch checkbox input</h5>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Default switch
                                            checkbox input</label>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <h5>Select</h5>
                                    <div class="rbt-modern-select bg-transparent height-45">
                                        <select class="w-100">
                                            <option>Barisal</option>
                                            <option>Dhaka</option>
                                            <option>Khulna</option>
                                            <option>Comilla</option>
                                            <option>Chittagong</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <h5>Select</h5>
                                    <div class="rbt-modern-select bg-transparent height-45 w-100">
                                        <select class="w-100" data-live-search="true" title="Select Author" multiple data-size="7" data-actions-box="true" data-selected-text-format="count > 2">
                                            <option data-subtext="Experts">Janin Afsana</option>
                                            <option data-subtext="Experts">Joe Biden</option>
                                            <option data-subtext="Experts">Fatima Asrafy</option>
                                            <option data-subtext="Experts">Aysha Baby</option>
                                            <option data-subtext="Experts">Mohamad Ali</option>
                                            <option data-subtext="Experts">Jone Li</option>
                                            <option data-subtext="Experts">Alberd Roce</option>
                                            <option data-subtext="Experts">Zeliski Noor</option>
                                        </select>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>

                    <div id="pagination" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Pagination</h4>
                            </div>
                            <div class="row g-5">
                                <div class="col-lg-12">
                                    <nav>
                                        <ul class="rbt-pagination justify-content-start">
                                            <li><a href="#" aria-label="Previous"><i
                                                        class="feather-chevron-left"></i></a></li>
                                            <li><a href="#">1</a></li>
                                            <li class="active"><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#" aria-label="Next"><i class="feather-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="col-lg-12">
                                    <nav>
                                        <ul class="rbt-pagination justify-content-center">
                                            <li><a href="#" aria-label="Previous"><i
                                                        class="feather-chevron-left"></i></a></li>
                                            <li><a href="#">1</a></li>
                                            <li class="active"><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#" aria-label="Next"><i class="feather-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                                <div class="col-lg-12">
                                    <nav>
                                        <ul class="rbt-pagination justify-content-end">
                                            <li><a href="#" aria-label="Previous"><i
                                                        class="feather-chevron-left"></i></a></li>
                                            <li><a href="#">1</a></li>
                                            <li class="active"><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#" aria-label="Next"><i class="feather-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tooltips" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Tooltips</h4>
                            </div>
                            <div class="row g-5">
                                <div class="col-lg-6">
                                    <div class="profile-share">
                                        <a href="#" class="avatar" data-tooltip="Mark JOrdan" tabindex="0"><img src="{{ asset('assets/images/testimonial/client-04.png') }}" alt="education"></a>
                                        <a href="#" class="avatar" data-tooltip="Mark" tabindex="0"><img src="{{ asset('assets/images/testimonial/client-05.png') }}" alt="education"></a>
                                        <a href="#" class="avatar" data-tooltip="Jordan" tabindex="0"><img src="{{ asset('assets/images/testimonial/client-06.png') }}" alt="education"></a>
                                        <div class="more-author-text">
                                            <h5 class="total-join-students">Join Over 3000+ Students</h5>
                                            <p class="subtitle">Have a new ideas every week.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="avatars" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Avatars</h4>
                            </div>
                            <div class="row g-5 align-items-center">
                                <div class="col-lg-2">
                                    <div class="rbt-avatars m-auto size-lg">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-1.jpg') }}" alt="Author Images">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="rbt-avatars m-auto">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-2.jpg') }}" alt="Author Images">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="rbt-avatars m-auto size-sm">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-3.jpg') }}" alt="Author Images">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="animatedHeading" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Animated Heading</h4>
                            </div>
                            <div class="row g-5">
                                <div class="col-lg-12">

                                    <h3 class="title">Clip Animated
                                        <span class="header-caption">
                                            <span class="cd-headline clip is-full-width">
                                                <span class="cd-words-wrapper">
                                                    <b class="is-visible theme-gradient">Clip One.</b>
                                                    <b class="is-hidden theme-gradient">Clip Two.</b>
                                                    <b class="is-hidden theme-gradient">Clip Three.</b>
                                                </span>
                                        </span>
                                        </span>
                                    </h3>

                                    <h3 class="title">Rotate Animated
                                        <span class="header-caption">
                                            <span class="cd-headline rotate-1">
                                                <span class="cd-words-wrapper">
                                                    <b class="is-visible theme-gradient">Rotate One.</b>
                                                    <b class="is-hidden theme-gradient">Rotate Two.</b>
                                                    <b class="is-hidden theme-gradient">Rotate Three.</b>
                                                </span>
                                        </span>
                                        </span>
                                    </h3>

                                    <h3 class="title">Type Animated
                                        <span class="header-caption">
                                            <span class="cd-headline type">
                                                <span class="cd-words-wrapper">
                                                    <b class="is-visible theme-gradient">Type One.</b>
                                                    <b class="is-hidden theme-gradient">Type Two.</b>
                                                    <b class="is-hidden theme-gradient">Type Three.</b>
                                                </span>
                                        </span>
                                        </span>
                                    </h3>

                                    <h3 class="title">Loading Animated
                                        <span class="header-caption">
                                            <span class="cd-headline loading-bar">
                                                <span class="cd-words-wrapper">
                                                    <b class="is-visible theme-gradient">Loading One.</b>
                                                    <b class="is-hidden theme-gradient">Loading Two.</b>
                                                    <b class="is-hidden theme-gradient">Loading Three.</b>
                                                </span>
                                        </span>
                                        </span>
                                    </h3>

                                    <h3 class="title">Zoom Animated
                                        <span class="header-caption">
                                            <span class="cd-headline zoom">
                                                <span class="cd-words-wrapper">
                                                    <b class="is-visible theme-gradient">Zoom One.</b>
                                                    <b class="is-hidden theme-gradient">Zoom Two.</b>
                                                    <b class="is-hidden theme-gradient">Zoom Three.</b>
                                                </span>
                                        </span>
                                        </span>
                                    </h3>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="rbtBorderRadius" class="rbt-elements-area bg-color-white rbt-shadow-box mb--60">
                        <div class="wrapper">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Border Radius</h4>
                            </div>
                            <div class="row g-5">

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary rbt-radius"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2 text-lowercase">radius</span>
                                            <h6 class="title mb--0">Radius Default</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary radius-4"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2 text-lowercase">radius-4</span>
                                            <h6 class="title mb--0">Radius 4px</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary radius-6"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2 text-lowercase">radius-6</span>
                                            <h6 class="title mb--0">Radius 6px</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary radius-10"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2 text-lowercase">radius-10</span>
                                            <h6 class="title mb--0">Radius 10px</h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="color-box-inner">
                                        <div class="color-box bg-color-primary radius-round"></div>
                                        <div class="content mt--10">
                                            <span class="rbt-title-style-2 text-lowercase">radius-round</span>
                                            <h6 class="title mb--0">Radius Round</h6>
                                        </div>
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
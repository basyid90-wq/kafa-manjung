<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElementsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'mainDemo')->name('mainDemo');
});

//  demo
Route::prefix('blog')->group(function () {
    Route::controller(BlogController::class)->group(function () {
            Route::get('/blog','blog')->name('blog');
            Route::get('/blog-details','blogDetails')->name('blogDetails');
            Route::get('/blog-grid-minimal','blogGridMinimal')->name('blogGridMinimal');
            Route::get('/blog-list','blogList')->name('blogList');
            Route::get('/blog-with-sidebar','blogWithSidebar')->name('blogWithSidebar');
            Route::get('/post-format-audio','postFormatAudio')->name('postFormatAudio');
            Route::get('/post-format-gallery','postFormatGallery')->name('postFormatGallery');
            Route::get('/post-format-quote','postFormatQuote')->name('postFormatQuote');
            Route::get('/post-format-standard','postFormatStandard')->name('postFormatStandard');
            Route::get('/post-format-video','postFormatVideo')->name('postFormatVideo');
    });
});

//  courses
Route::prefix('courses')->group(function () {
    Route::controller(CoursesController::class)->group(function () {
            Route::get('/course-card-2','courseCard2')->name('courseCard2');
            Route::get('/course-card-3','courseCard3')->name('courseCard3');
            Route::get('/course-details','courseDetails')->name('courseDetails');
            Route::get('/course-details-2','courseDetails2')->name('courseDetails2');
            Route::get('/course-details-3','courseDetails3')->name('courseDetails3');
            Route::get('/course-filter-one-open','courseFilterOneOpen')->name('courseFilterOneOpen');
            Route::get('/course-filter-one-toggle','courseFilterOneToggle')->name('courseFilterOneToggle');
            Route::get('/course-filter-two-open','courseFilterTwoOpen')->name('courseFilterTwoOpen');
            Route::get('/course-filter-two-toggle','courseFilterTwoToggle')->name('courseFilterTwoToggle');
            Route::get('/course-masonry','courseMasonry')->name('courseMasonry');
            Route::get('/course-with-sidebar','courseWithSidebar')->name('courseWithSidebar');
            Route::get('/course-with-tab','courseWithTab')->name('courseWithTab');
            Route::get('/course-with-tab-two','courseWithTabTwo')->name('courseWithTabTwo');
            Route::get('/create-course','createCourse')->name('createCourse');
            Route::get('/instructor-course','instructorCourse')->name('instructorCourse');
            Route::get('/lesson','lesson')->name('lesson');
    });
});

//  Instructor-dashboard
Route::prefix('dashboard')->group(function () {
    Route::prefix('instructor-dashboard')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/instructor-announcements','instructorAnnouncements')->name('instructorAnnouncements');
            Route::get('/instructor-assignments','instructorAssignments')->name('instructorAssignments');
            Route::get('/instructor-dashboard','instructorDashboard')->name('instructorDashboard');
            Route::get('/instructor-enrolled-courses','instructorEnrolledCourses')->name('instructorEnrolledCourses');
            Route::get('/instructor-my-quizAttempts','instructorMyQuizAttempts')->name('instructorMyQuizAttempts');
            Route::get('/instructor-orderHistory','instructorOrderHistory')->name('instructorOrderHistory');
            Route::get('/instructor-profile','instructorProfile')->name('instructorProfile');
            Route::get('/instructor-quiz-attempts','instructorQuizAttempts')->name('instructorQuizAttempts');
            Route::get('/instructor-reviews','instructorReviews')->name('instructorReviews');
            Route::get('/instructor-settings','instructorSettings')->name('instructorSettings');
            Route::get('/instructor-wishlist','instructorWishlist')->name('instructorWishlist');
        });
    });
});

//  student-dashboard
Route::prefix('dashboard')->group(function () {
    Route::prefix('student-dashboard')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/student-dashboard','studentDashboard')->name('studentDashboard');
            Route::get('/student-enrolled-courses','studentEnrolledCourses')->name('studentEnrolledCourses');
            Route::get('/student-my-quiz-attempts','studentMyQuizAttempts')->name('studentMyQuizAttempts');
            Route::get('/student-order-history','studentOrderHistory')->name('studentOrderHistory');
            Route::get('/student-profile','studentProfile')->name('studentProfile');
            Route::get('/student-reviews','studentReviews')->name('studentReviews');
            Route::get('/student-settings','studentSettings')->name('studentSettings');
            Route::get('/student-wishlist','studentWishlist')->name('studentWishlist');
        });
    });
});

//  courses
Route::prefix('elements')->group(function () {
    Route::controller(ElementsController::class)->group(function () {
        Route::get('/about', 'about')->name('about');
        Route::get('/accordion', 'accordion')->name('accordion');
        Route::get('/advancetab', 'advancetab')->name('advancetab');
        Route::get('/badge', 'badge')->name('badge');
        Route::get('/brand', 'brand')->name('brand');
        Route::get('/button', 'button')->name('button');
        Route::get('/call-to-action', 'callToAction')->name('callToAction');
        Route::get('/card', 'card')->name('card');
        Route::get('/category', 'category')->name('category');
        Route::get('/counterup', 'counterup')->name('counterup');
        Route::get('/gallery', 'gallery')->name('gallery');
        Route::get('/header', 'header')->name('header');
        Route::get('/instagram', 'instagram')->name('instagram');
        Route::get('/listStyle', 'listStyle')->name('listStyle');
        Route::get('/newsletter', 'newsletter')->name('newsletter');
        Route::get('/pricing', 'pricing')->name('pricing');
        Route::get('/progressbar', 'progressbar')->name('progressbar');
        Route::get('/search', 'search')->name('search');
        Route::get('/service', 'service')->name('service');
        Route::get('/social', 'social')->name('social');
        Route::get('/split', 'split')->name('split');
        Route::get('/style-guide', 'styleGuide')->name('styleGuide');
        Route::get('/team', 'team')->name('team');
        Route::get('/testimonial', 'testimonial')->name('testimonial');
    });
});

//  courses
Route::prefix('home')->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/main-demo','mainDemo')->name('mainDemo');
        Route::get('/art-design-school','artDesignSchool')->name('artDesignSchool');
        Route::get('/checkout','checkout')->name('checkout');
        Route::get('/classic-lms','classicLms')->name('classicLms');
        Route::get('/coaching','coaching')->name('coaching');
        Route::get('/course-school','courseSchool')->name('courseSchool');
        Route::get('/gym-coaching','gymCoaching')->name('gymCoaching');
        Route::get('/health-wellness-institute','healthWellnessInstitute')->name('healthWellnessInstitute');
        Route::get('/home-elegant','homeElegant')->name('homeElegant');
        Route::get('/home-technology','homeTechnology')->name('homeTechnology');
        Route::get('/instructor-course','instructorCourse')->name('instructorCourse');
        Route::get('/instructor-portfolio','instructorPortfolio')->name('instructorPortfolio');
        Route::get('/instructors-coaches','instructorsCoaches')->name('instructorsCoaches');
        Route::get('/islamic-center','islamicCenter')->name('islamicCenter');
        Route::get('/kindergarten','kindergarten')->name('kindergarten');
        Route::get('/language-academy','languageAcademy')->name('languageAcademy');
        Route::get('/life-coach','lifeCoach')->name('lifeCoach');
        Route::get('/marketplace','marketplace')->name('marketplace');
        Route::get('/modern-university','modernUniversity')->name('modernUniversity');
        Route::get('/multilingual','multilingual')->name('multilingual');
        Route::get('/online-academy','onlineAcademy')->name('onlineAcademy');
        Route::get('/online-course','onlineCourse')->name('onlineCourse');
        Route::get('/online-school','onlineSchool')->name('onlineSchool');
        Route::get('/single-course','singleCourse')->name('singleCourse');
        Route::get('/udemy-affiliate','udemyAffiliate')->name('udemyAffiliate');
        Route::get('/university-classic','universityClassic')->name('universityClassic');
        Route::get('/university-status','universityStatus')->name('universityStatus');
        Route::get('/wishlist','wishlist')->name('wishlist');
    });
});

    //  courses
Route::prefix('pages')->group(function () {
    Route::controller(pagesController::class)->group(function () {
        Route::get('/page-error' ,'pageError')->name('pageError');
        Route::get('/aboutus-01' ,'aboutus01')->name('aboutus01');
        Route::get('/aboutus-02' ,'aboutus02')->name('aboutus02');
        Route::get('/academy-gallery' ,'academyGallery')->name('academyGallery');
        Route::get('/admission-guide' ,'admissionGuide')->name('admissionGuide');
        Route::get('/become-teacher' ,'becomeTeacher')->name('becomeTeacher');
        Route::get('/cart' ,'cart')->name('cart');
        Route::get('/contact' ,'contact')->name('contact');
        Route::get('/event-details' ,'eventDetails')->name('eventDetails');
        Route::get('/event-grid' ,'eventGrid')->name('eventGrid');
        Route::get('/event-list' ,'eventList')->name('eventList');
        Route::get('/event-sidebar' ,'eventSidebar')->name('eventSidebar');
        Route::get('/faqs' ,'faqs')->name('faqs');
        Route::get('/instructor' ,'instructor')->name('instructor');
        Route::get('/login' ,'login')->name('login');
        Route::get('/maintenance' ,'maintenance')->name('maintenance');
        Route::get('/myAccount' ,'myAccount')->name('myAccount');
        Route::get('/privacy-policy' ,'privacyPolicy')->name('privacyPolicy');
        Route::get('/profile' ,'profile')->name('profile');
        Route::get('/shop' ,'shop')->name('shop');
        Route::get('/single-product' ,'singleProduct')->name('singleProduct');
        Route::get('/subscription' ,'subscription')->name('subscription');
        Route::get('/wishlist-2' ,'wishlist2')->name('wishlist2');
    });
});

//  courses
Route::prefix('main')->group(function () {
    Route::controller(MainController::class)->group(function () {
        Route::get('/all-questions','allQuestions')->name('allQuestions');
        Route::get('/elements','elements')->name('elements');
        Route::get('/header-layout','headerLayout')->name('headerLayout');
        Route::get('/lesson-assignments','lessonAssignments')->name('lessonAssignments');
        Route::get('/lesson-assignments-submit','lessonAssignmentsSubmit')->name('lessonAssignmentsSubmit');
        Route::get('/lesson-ntro','lessonIntro')->name('lessonIntro');
        Route::get('/lesson-quiz','lessonQuiz')->name('lessonQuiz');
        Route::get('/lesson-quiz-result','lessonQuizResult')->name('lessonQuizResult');
        Route::get('/modal','modal')->name('modal');
        Route::get('/pagination-quiz','paginationQuiz')->name('paginationQuiz');
        Route::get('/purchase-guide','purchaseGuide')->name('purchaseGuide');
        Route::get('/questions-types','questionsTypes')->name('questionsTypes');
        Route::get('/quiz-with-custom-timer','quizWithCustomTimer')->name('quizWithCustomTimer');
        Route::get('/quiz-with-point','quizWithPoint')->name('quizWithPoint');
        Route::get('/sample-page-one','samplePageOne')->name('samplePageOne');
        Route::get('/sample-page-two','samplePageTwo')->name('samplePageTwo');
        Route::get('/single-question','singleQuestion')->name('singleQuestion');
    });
});
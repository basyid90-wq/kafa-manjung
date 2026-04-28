<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function allQuestions()
    {
        return view('allQuestions');
    }

    public function elements()
    {
        return view('elements');
    }

    public function headerLayout()
    {
        return view('headerLayout');
    }

    public function lessonAssignments()
    {
        return view('lessonAssignments');
    }

    public function lessonAssignmentsSubmit()
    {
        return view('lessonAssignmentsSubmit');
    }

    public function lessonIntro()
    {
        return view('lessonIntro');
    }

    public function lessonQuiz()
    {
        return view('lessonQuiz');
    }

    public function lessonQuizResult()
    {
        return view('lessonQuizResult');
    }

    public function modal()
    {
        return view('modal');
    }

    public function paginationQuiz()
    {
        return view('paginationQuiz');
    }

    public function purchaseGuide()
    {
        return view('purchaseGuide');
    }

    public function questionsTypes()
    {
        return view('questionsTypes');
    }

    public function quizWithCustomTimer()
    {
        return view('quizWithCustomTimer');
    }

    public function quizWithPoint()
    {
        return view('quizWithPoint');
    }

    public function samplePageOne()
    {
        return view('samplePageOne');
    }

    public function samplePageTwo()
    {
        return view('samplePageTwo');
    }

    public function singleQuestion()
    {
        return view('singleQuestion');
    }
}

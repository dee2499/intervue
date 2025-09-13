<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Submission;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isCandidate()) {

            $interviews = Interview::all();
            return view('candidate.home', compact('interviews'));
        } else {

            $interviews = Interview::where('created_by', auth()->id())->get();
            $submissions = Submission::whereHas('question.interview', function ($query) {
                $query->where('created_by', auth()->id());
            })->with(['candidate', 'question.interview'])->get();

            return view('reviewer.home', compact('interviews', 'submissions'));
        }
    }
}

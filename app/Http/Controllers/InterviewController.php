<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::where('created_by', Auth::id())->get();
        return view('interviews.index', compact('interviews'));
    }

    public function create()
    {
        return view('interviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.time_limit' => 'nullable|integer|min:1',
        ]);

        $interview = Interview::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->questions as $question) {
            Question::create([
                'question_text' => $question['text'],
                'time_limit' => $question['time_limit'] ?? null,
                'interview_id' => $interview->id,
            ]);
        }

        return redirect()->route('interviews.show', $interview->id)
            ->with('success', 'Interview created successfully.');
    }

    public function show($id)
    {
        $interview = Interview::with('questions')->findOrFail($id);
        return view('interviews.show', compact('interview'));
    }

    public function edit($id)
    {
        $interview = Interview::with('questions')->findOrFail($id);

        if ($interview->created_by != Auth::id()) {
            return redirect()->route('interviews.index')
                ->with('error', 'You are not authorized to edit this interview.');
        }

        return view('interviews.edit', compact('interview'));
    }

    public function update(Request $request, $id)
    {
        $interview = Interview::findOrFail($id);

        if ($interview->created_by != Auth::id()) {
            return redirect()->route('interviews.index')
                ->with('error', 'You are not authorized to update this interview.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.time_limit' => 'nullable|integer|min:1',
        ]);

        $interview->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);


        $interview->questions()->delete();


        foreach ($request->questions as $question) {
            Question::create([
                'question_text' => $question['text'],
                'time_limit' => $question['time_limit'] ?? null,
                'interview_id' => $interview->id,
            ]);
        }

        return redirect()->route('interviews.show', $interview->id)
            ->with('success', 'Interview updated successfully.');
    }

    public function destroy($id)
    {
        $interview = Interview::findOrFail($id);

        if ($interview->created_by != Auth::id()) {
            return redirect()->route('interviews.index')
                ->with('error', 'You are not authorized to delete this interview.');
        }

        $interview->delete();

        return redirect()->route('interviews.index')
            ->with('success', 'Interview deleted successfully.');
    }

    public function takeInterview($id)
    {
        $interview = Interview::with('questions')->findOrFail($id);
        return view('interviews.take', compact('interview'));
    }
}

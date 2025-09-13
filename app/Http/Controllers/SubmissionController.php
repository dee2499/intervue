<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::whereHas('question.interview', function ($query) {
            $query->where('created_by', Auth::id());
        })->with(['candidate', 'question.interview', 'reviews'])->get();

        return view('submissions.index', compact('submissions'));
    }

    /*public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'video' => 'required|mimes:mp4,mov,avi|max:102400', // Max 100MB
        ]);

        $question = Question::findOrFail($request->question_id);

        // Check if the user has already submitted an answer for this question
        $existingSubmission = Submission::where('candidate_id', Auth::id())
            ->where('question_id', $question->id)
            ->first();

        if ($existingSubmission) {
            return redirect()->back()
                ->with('error', 'You have already submitted an answer for this question.');
        }

        // Store the video
        $videoPath = $request->file('video')->store('submissions', 'public');
        $videoUrl = Storage::url($videoPath);

        $submission = Submission::create([
            'video_url' => $videoUrl,
            'candidate_id' => Auth::id(),
            'question_id' => $question->id,
        ]);

        return redirect()->route('interviews.take', $question->interview_id)
            ->with('success', 'Your answer has been submitted successfully.');
    }*/

    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'video' => 'sometimes|required|mimes:mp4,mov,avi,webm|max:102400',
            'video_base64' => 'sometimes|required|string',
        ]);

        $question = Question::findOrFail($request->question_id);


        $existingSubmission = Submission::where('candidate_id', Auth::id())
            ->where('question_id', $question->id)
            ->first();

        if ($existingSubmission) {
            return redirect()->back()
                ->with('error', 'You have already submitted an answer for this question.');
        }


        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoPath = $videoFile->store('submissions', 'public');
            $videoUrl = Storage::url($videoPath);
        } else if ($request->video_base64) {
            $base64Data = $request->video_base64;

            if (strpos($base64Data, 'data:video/webm;base64,') === 0) {
                $base64Data = substr($base64Data, strlen('data:video/webm;base64,'));
            }

            $videoData = base64_decode($base64Data);

            $filename = 'recording_' . auth()->id() . '_' . time() . '.webm';
            $videoPath = 'submissions/' . $filename;

            Storage::disk('public')->put($videoPath, $videoData);
            $videoUrl = Storage::url($videoPath);
        } else {
            return redirect()->back()
                ->with('error', 'No video provided.');
        }

        $submission = Submission::create([
            'video_url' => $videoUrl,
            'candidate_id' => Auth::id(),
            'question_id' => $question->id,
        ]);

        return redirect()->route('interviews.take', $question->interview_id)
            ->with('success', 'Your answer has been submitted successfully.');
    }

    public function show($id)
    {
        $submission = Submission::with(['candidate', 'question.interview', 'reviews.reviewer'])
            ->findOrFail($id);


        if (Auth::id() != $submission->candidate_id &&
            Auth::id() != $submission->question->interview->created_by) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to view this submission.');
        }

        return view('submissions.show', compact('submission'));
    }

    public function destroy($id)
    {
        $submission = Submission::findOrFail($id);

        if ($submission->candidate_id != Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to delete this submission.');
        }

        $videoPath = str_replace('/storage/', '', $submission->video_url);
        Storage::disk('public')->delete($videoPath);

        $submission->delete();

        return redirect()->route('interviews.take', $submission->question->interview_id)
            ->with('success', 'Your submission has been deleted successfully.');
    }
}

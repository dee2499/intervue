<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id',
            'score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        $submission = Submission::findOrFail($request->submission_id);


        if (Auth::id() != $submission->question->interview->created_by) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to review this submission.');
        }


        $existingReview = Review::where('reviewer_id', Auth::id())
            ->where('submission_id', $submission->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'You have already reviewed this submission.');
        }

        $review = Review::create([
            'score' => $request->score,
            'comments' => $request->comments,
            'reviewer_id' => Auth::id(),
            'submission_id' => $submission->id,
        ]);

        return redirect()->route('submissions.show', $submission->id)
            ->with('success', 'Your review has been submitted successfully.');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);


        if ($review->reviewer_id != Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to edit this review.');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);


        if ($review->reviewer_id != Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to update this review.');
        }

        $request->validate([
            'score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        $review->update([
            'score' => $request->score,
            'comments' => $request->comments,
        ]);

        return redirect()->route('submissions.show', $review->submission_id)
            ->with('success', 'Your review has been updated successfully.');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);


        if ($review->reviewer_id != Auth::id()) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to delete this review.');
        }

        $submissionId = $review->submission_id;
        $review->delete();

        return redirect()->route('submissions.show', $submissionId)
            ->with('success', 'Your review has been deleted successfully.');
    }
}

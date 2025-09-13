@extends('layouts.app')

@section('title', 'Submission Details')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Submission by {{ $submission->candidate->name }}</h4>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <h5>Interview: {{ $submission->question->interview->title }}</h5>
                <p class="mb-2"><strong>Question:</strong> {{ $submission->question->question_text }}</p>
                <p class="mb-2"><strong>Submitted At:</strong> {{ $submission->created_at->format('M d, Y H:i:s') }}</p>
                @if ($submission->question->time_limit)
                    <p class="mb-2"><strong>Time Limit:</strong> {{ $submission->question->time_limit }} seconds</p>
                @endif
            </div>

            <div class="mb-4">
                <h5>Answer</h5>
                <div class="ratio ratio-16x9">
                    <video src="{{ asset($submission->video_url) }}" controls></video>
                </div>
            </div>

            <div class="mb-4">
                <h5>Reviews</h5>
                @if ($submission->reviews->count() > 0)
                    <div class="list-group">
                        @foreach ($submission->reviews as $review)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6>{{ $review->reviewer->name }}</h6>
                                        <div class="mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->score)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-warning"></i>
                                                @endif
                                            @endfor
                                            <span class="ms-2">{{ $review->score }}/5</span>
                                        </div>
                                        @if ($review->comments)
                                            <p>{{ $review->comments }}</p>
                                        @endif
                                    </div>
                                    @if (auth()->id() == $review->reviewer_id)
                                        <div>
                                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No reviews yet.</p>
                @endif
            </div>

            @if (auth()->id() == $submission->question->interview->created_by)
                <div class="mb-4">
                    <h5>Add Review</h5>
                    @if (!$submission->reviews()->where('reviewer_id', auth()->id())->exists())
                        <form method="POST" action="{{ route('reviews.store') }}">
                            @csrf
                            <input type="hidden" name="submission_id" value="{{ $submission->id }}">

                            <div class="mb-3">
                                <label for="score" class="form-label">Score (1-5)</label>
                                <select id="score" class="form-select" name="score" required>
                                    <option value="">Select a score</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Below Average</option>
                                    <option value="3">3 - Average</option>
                                    <option value="4">4 - Good</option>
                                    <option value="5">5 - Excellent</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="comments" class="form-label">Comments</label>
                                <textarea id="comments" class="form-control" name="comments" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Submit Review
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            You have already reviewed this submission.
                        </div>
                    @endif
                </div>
            @endif

            <div class="d-flex justify-content-between">
                <a href="{{ route('submissions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Submissions
                </a>
                @if (auth()->id() == $submission->candidate_id)
                    <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this submission?')">
                            <i class="fas fa-trash"></i> Delete Submission
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

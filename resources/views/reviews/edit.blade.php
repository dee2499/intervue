@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
    <div class="card">
        <div class="card-header">Edit Review</div>

        <div class="card-body">
            <form method="POST" action="{{ route('reviews.update', $review->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="score" class="form-label">Score (1-5)</label>
                    <select id="score" class="form-select @error('score') is-invalid @enderror" name="score" required>
                        <option value="">Select a score</option>
                        <option value="1" {{ old('score', $review->score) == 1 ? 'selected' : '' }}>1 - Poor</option>
                        <option value="2" {{ old('score', $review->score) == 2 ? 'selected' : '' }}>2 - Below Average</option>
                        <option value="3" {{ old('score', $review->score) == 3 ? 'selected' : '' }}>3 - Average</option>
                        <option value="4" {{ old('score', $review->score) == 4 ? 'selected' : '' }}>4 - Good</option>
                        <option value="5" {{ old('score', $review->score) == 5 ? 'selected' : '' }}>5 - Excellent</option>
                    </select>
                    @error('score')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comments" class="form-label">Comments</label>
                    <textarea id="comments" class="form-control @error('comments') is-invalid @enderror" name="comments" rows="3">{{ old('comments', $review->comments) }}</textarea>
                    @error('comments')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        Update Review
                    </button>
                    <a href="{{ route('submissions.show', $review->submission_id) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

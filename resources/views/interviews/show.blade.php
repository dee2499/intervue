@extends('layouts.app')

@section('title', 'Interview Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>{{ $interview->title }}</h4>
            <div>
                <a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('interviews.take', $interview->id) }}" class="btn btn-info">
                    <i class="fas fa-video"></i> Take Interview
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <h5>Description</h5>
                <p>{{ $interview->description ?? 'No description provided.' }}</p>
            </div>

            <div class="mb-4">
                <h5>Questions ({{ $interview->questions->count() }})</h5>
                @if ($interview->questions->count() > 0)
                    <div class="list-group">
                        @foreach ($interview->questions as $question)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>{{ $question->question_text }}</h6>
                                        @if ($question->time_limit)
                                            <small class="text-muted">Time Limit: {{ $question->time_limit }} seconds</small>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('submissions.index') }}?question_id={{ $question->id }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View Submissions
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No questions added yet.</p>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('interviews.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Interviews
                </a>
                <form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this interview?')">
                        <i class="fas fa-trash"></i> Delete Interview
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

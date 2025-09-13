@extends('layouts.app')

@section('title', 'Reviewer Dashboard')

@section('content')
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>My Interviews</h4>
            <a href="{{ route('interviews.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Interview
            </a>
        </div>

        <div class="card-body">
            @if ($interviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Questions</th>
                            <th>Submissions</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($interviews as $interview)
                            <tr>
                                <td>{{ $interview->title }}</td>
                                <td>{{ $interview->questions->count() }}</td>
                                <td>
                                        <?php
                                        $submissionCount = 0;
                                        foreach ($interview->questions as $question) {
                                            $submissionCount += $question->submissions->count();
                                        }
                                        ?>
                                    {{ $submissionCount }}
                                </td>
                                <td>{{ $interview->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('interviews.show', $interview->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <p>You haven't created any interviews yet.</p>
                    <a href="{{ route('interviews.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Your First Interview
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Recent Submissions</h4>
            <a href="{{ route('submissions.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> View All Submissions
            </a>
        </div>

        <div class="card-body">
            @if ($submissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Candidate</th>
                            <th>Interview</th>
                            <th>Question</th>
                            <th>Submitted At</th>
                            <th>Reviews</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($submissions->take(5) as $submission)
                            <tr>
                                <td>{{ $submission->candidate->name }}</td>
                                <td>{{ $submission->question->interview->title }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($submission->question->question_text, 50) }}</td>
                                <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    @if ($submission->reviews->count() > 0)
                                        <span class="badge bg-info">{{ $submission->reviews->count() }} review(s)</span>
                                        @if ($submission->reviews->avg('score'))
                                            <span class="badge bg-warning">Avg: {{ number_format($submission->reviews->avg('score'), 1) }}/5</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">No reviews</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('submissions.show', $submission->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($submissions->count() > 5)
                    <div class="text-center mt-3">
                        <a href="{{ route('submissions.index') }}" class="btn btn-primary">
                            View All Submissions
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-4">
                    <p>No submissions found.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

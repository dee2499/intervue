@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Submissions</h4>
        </div>

        <div class="card-body">
            @if ($submissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Candidate</th>
                            <th>Interview</th>
                            <th>Question</th>
                            <th>Submitted At</th>
                            <th>Reviews</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($submissions as $submission)
                            <tr>
                                <td>{{ $submission->id }}</td>
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
            @else
                <div class="text-center py-4">
                    <p>No submissions found.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

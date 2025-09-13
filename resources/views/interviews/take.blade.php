@extends('layouts.app')

@section('title', 'Take Interview')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $interview->title }}</h4>
                        <p class="mb-0">{{ $interview->description ?? 'No description provided.' }}</p>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="accordion" id="questionsAccordion">
                            @foreach ($interview->questions as $index => $question)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                            Question {{ $index + 1 }}
                                            @if ($question->time_limit)
                                                <span class="badge bg-secondary ms-2">{{ $question->time_limit }}s</span>
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#questionsAccordion">
                                        <div class="accordion-body">
                                            <p class="mb-3">{{ $question->question_text }}</p>

                                            @if ($question->time_limit)
                                                <div class="alert alert-info">
                                                    <i class="fas fa-clock"></i> Time Limit: {{ $question->time_limit }} seconds
                                                </div>
                                            @endif

                                            @if ($submission = $question->submissions()->where('candidate_id', auth()->id())->first())
                                                <div class="alert alert-success mt-3">
                                                    <i class="fas fa-check-circle"></i> You have already submitted an answer for this question.
                                                    <a href="{{ route('submissions.show', $submission->id) }}" class="btn btn-sm btn-info ms-2">
                                                        <i class="fas fa-eye"></i> View Your Answer
                                                    </a>
                                                </div>
                                            @else
                                                <div class="mt-3">
                                                    <h5>Record Your Answer</h5>
                                                    <x-video-recorder :questionId="$question->id" />

                                                    <div class="text-center mt-3">
                                                        <p class="text-muted">or</p>
                                                    </div>

                                                    <h5>Upload a Video File</h5>
                                                    <form method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                                                        <div class="mb-3">
                                                            <input type="file" class="form-control" name="video" accept="video/*" required>
                                                            <div class="form-text">Accepted formats: MP4, MOV, AVI, WebM. Max size: 100MB.</div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-upload"></i> Upload Video
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <a href="{{ url('/home') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

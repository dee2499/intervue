@extends('layouts.app')

@section('title', 'Edit Interview')

@section('content')
    <div class="card">
        <div class="card-header">Edit Interview</div>

        <div class="card-body">
            <form method="POST" action="{{ route('interviews.update', $interview->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $interview->title) }}" required autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $interview->description) }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Questions</label>
                    <div id="questions-container">
                        @foreach ($interview->questions as $index => $question)
                            <div class="question-item mb-3 p-3 border rounded">
                                <div class="mb-2">
                                    <label class="form-label">Question Text</label>
                                    <input type="text" class="form-control question-text" name="questions[{{ $index }}][text]" value="{{ $question->question_text }}" required>
                                </div>
                                <div>
                                    <label class="form-label">Time Limit (seconds, optional)</label>
                                    <input type="number" class="form-control question-time-limit" name="questions[{{ $index }}][time_limit]" value="{{ $question->time_limit }}" min="1">
                                </div>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-question">
                                    <i class="fas fa-trash"></i> Remove
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-question" class="btn btn-secondary mt-2">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        Update Interview
                    </button>
                    <a href="{{ route('interviews.show', $interview->id) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionCount = {{ $interview->questions->count() }};

            document.getElementById('add-question').addEventListener('click', function() {
                const container = document.getElementById('questions-container');
                const questionItem = document.createElement('div');
                questionItem.className = 'question-item mb-3 p-3 border rounded';
                questionItem.innerHTML = `
                <div class="mb-2">
                    <label class="form-label">Question Text</label>
                    <input type="text" class="form-control question-text" name="questions[${questionCount}][text]" required>
                </div>
                <div>
                    <label class="form-label">Time Limit (seconds, optional)</label>
                    <input type="number" class="form-control question-time-limit" name="questions[${questionCount}][time_limit]" min="1">
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-2 remove-question">
                    <i class="fas fa-trash"></i> Remove
                </button>
            `;
                container.appendChild(questionItem);
                questionCount++;


                questionItem.querySelector('.remove-question').addEventListener('click', function() {
                    questionItem.remove();
                });
            });


            document.querySelectorAll('.remove-question').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.question-item').remove();
                });
            });
        });
    </script>
@endsection

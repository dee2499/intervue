@extends('layouts.app')

@section('title', 'Create Interview')

@section('content')
    <div class="card">
        <div class="card-header">Create New Interview</div>

        <div class="card-body">
            <form method="POST" action="{{ route('interviews.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Questions</label>
                    <div id="questions-container">
                        <div class="question-item mb-3 p-3 border rounded">
                            <div class="mb-2">
                                <label class="form-label">Question Text</label>
                                <input type="text" class="form-control question-text" name="questions[0][text]" required>
                            </div>
                            <div>
                                <label class="form-label">Time Limit (seconds, optional)</label>
                                <input type="number" class="form-control question-time-limit" name="questions[0][time_limit]" min="1">
                            </div>
                        </div>
                    </div>
                    <button type="button" id="add-question" class="btn btn-secondary mt-2">
                        <i class="fas fa-plus"></i> Add Question
                    </button>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">
                        Create Interview
                    </button>
                    <a href="{{ route('interviews.index') }}" class="btn btn-secondary">
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
            let questionCount = 1;

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
        });
    </script>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Welcome, {{ auth()->user()->name }}!</h4>
            <p class="mb-0">Here are the available interviews for you to take.</p>
        </div>

        <div class="card-body">
            @if ($interviews->count() > 0)
                <div class="row">
                    @foreach ($interviews as $interview)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $interview->title }}</h5>
                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($interview->description ?? 'No description provided.', 100) }}</p>
                                    <p class="card-text"><small class="text-muted">{{ $interview->questions->count() }} question(s)</small></p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('interviews.take', $interview->id) }}" class="btn btn-primary">
                                        <i class="fas fa-video"></i> Take Interview
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <p>No interviews available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

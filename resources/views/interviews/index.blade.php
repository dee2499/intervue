@extends('layouts.app')

@section('title', 'My Interviews')

@section('content')
    <div class="card">
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
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Questions</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($interviews as $interview)
                            <tr>
                                <td>{{ $interview->id }}</td>
                                <td>{{ $interview->title }}</td>
                                <td>{{ $interview->description ?? 'N/A' }}</td>
                                <td>{{ $interview->questions->count() }}</td>
                                <td>{{ $interview->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('interviews.show', $interview->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this interview?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
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
@endsection

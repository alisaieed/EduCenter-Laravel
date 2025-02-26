@extends('layouts.app')

@section('content')
    <h1>Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Create New Department</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Head Instructor</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->head_instructor->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('departments.show', $department->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

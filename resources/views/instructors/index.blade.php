@extends('layouts.app')

@section('content')
    <h1>Instructors</h1>
    <a href="{{ route('instructors.create') }}" class="btn btn-primary">Add Instructor</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td>{{ $instructor->email }}</td>
                    <td>
                        <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

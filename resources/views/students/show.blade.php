@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3>Student Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Address:</strong> {{ $student->address }}</p>
            <p><strong>Phone:</strong> {{ $student->phone_number }}</p>

            <h4 class="mt-4">Assigned Courses</h4>
            <form action="{{ route('students.updateCourses', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Select</th>
                                <th>Course Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="courses[]" value="{{ $course->id }}" 
                                            class="form-check-input"
                                            {{ $student->courses->contains($course->id) ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $course->name }}</td>
                                    <td>
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">
                                            View Course
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-success mt-3">Update Courses</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">Back to Students</a>
            </form>
        </div>
    </div>
</div>
@endsection

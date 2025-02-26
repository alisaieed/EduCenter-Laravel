@extends('layouts.app')

@section('content')
<h1>Create Course</h1>
<form action="{{ route('courses.store') }}" method="POST">
    @csrf

    <!-- Course Name Field -->
    <div class="form-group">
        <label for="name">Course Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <!-- Course Description Field -->
    <div class="form-group">
        <label for="description">Course Description</label>
        <textarea name="description" id="description" class="form-control" required></textarea>
    </div>

    <!-- Instructor Field -->
    <div class="form-group">
        <label>Instructor</label>
        @foreach($instructors as $instructor)
            <div class="form-check">
                <input 
                    type="checkbox" 
                    name="instructor_ids[]" 
                    value="{{ $instructor->id }}" 
                    id="instructor_{{ $instructor->id }}" 
                    class="form-check-input"
                    {{ in_array($instructor->id, old('instructor_ids', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="instructor_{{ $instructor->id }}">
                    {{ $instructor->name }}
                </label>
            </div>
        @endforeach
    </div>

    <!-- Department Field -->
    <div class="form-group">
        <label for="department_id">Department</label>
        <select name="department_id" id="department_id" class="form-control" required>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>


    <!-- Start Date Field -->
    <div class="form-group">
        <label for="start_date">Start Date</label>
        <input type="date" name="start_date" id="start_date" class="form-control" required>
    </div>

    <!-- End Date Field -->
    <div class="form-group">
        <label for="end_date">End Date</label>
        <input type="date" name="end_date" id="end_date" class="form-control" required>
    </div>

    <!-- Certificate Field -->
    <div class="form-group">
        <label for="certificate_id">Certificate</label>
        <select name="certificate_id" id="certificate_id" class="form-control" >
            @foreach($certificates as $certificate)
                <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Create Course</button>
</form>
@endsection

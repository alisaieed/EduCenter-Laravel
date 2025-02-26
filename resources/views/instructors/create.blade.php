@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create New Instructor</h2>
        <form action="{{ route('instructors.store') }}" method="POST">
            @csrf

            <!-- Instructor Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Instructor Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Instructor Phone -->
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Department Selection (Optional) -->
            <div class="form-group">
                <label>Departments</label>
                @foreach($departments as $department)
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="departments[]" 
                            value="{{ $department->id }}" 
                            id="department_{{ $department->id }}" 
                            class="form-check-input"
                            {{ in_array($department->id, old('departments', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="department_{{ $department->id }}">
                            {{ $department->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Courses Selection (Optional) -->
            <div class="form-group">
                <label for="courses">Courses</label>
                <select name="courses[]" id="courses" class="form-control @error('courses') is-invalid @enderror" multiple>
                    <option value="">Select Courses (Optional)</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ in_array($course->id, old('courses', [])) ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('courses')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Instructor</button>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

<form action="{{ route('departments.store') }}" method="POST">
    @csrf  <!-- Laravel security token -->

    <!-- Department Name -->
    <div class="form-group">
        <label for="name">Department Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <!-- Description -->
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>

    <!-- Head Instructor Dropdown -->
    <div class="form-group">
        <label for="head_instructor_id">Head Instructor</label>
        <select name="head_instructor_id" id="head_instructor_id" class="form-control">
            <option value="">-- Select Head Instructor --</option>
            @foreach($instructors as $instructor)
                <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Instructors Checkboxes -->
    <div class="form-group">
        <label>Instructors</label>
        <div class="checkbox-group">
            @foreach($instructors as $instructor)
                <div class="form-check">
                    <input type="checkbox" name="instructors[]" value="{{ $instructor->id }}" class="form-check-input">
                    <label class="form-check-label">{{ $instructor->name }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-success">Create Department</button>
</form>

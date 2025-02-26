@extends('layouts.app')

@section('content')
    <h1>Edit Department</h1>
    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Department Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $department->name }}" required>
        </div>

        <div class="form-group">
            <label for="head_instructor_id">Head Instructor</label>
            <select name="head_instructor_id" id="head_instructor_id" class="form-control">
                <option value="">Select Head Instructor</option>
                @foreach ($instructors as $instructor)
                    <option value="{{ $instructor->id }}" 
                        {{ $department->head_instructor_id == $instructor->id ? 'selected' : '' }}>
                        {{ $instructor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3>Instructors in this Department:</h3>
        @foreach ($instructors as $instructor)
            <div class="form-check">
                <input type="checkbox" name="instructors[]" value="{{ $instructor->id }}" class="form-check-input"
                    {{ $department->instructors->contains($instructor->id) ? 'checked' : '' }}>
                <label for="instructor_{{ $instructor->id }}" class="form-check-label">{{ $instructor->name }}</label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Department</button>
    </form>
@endsection

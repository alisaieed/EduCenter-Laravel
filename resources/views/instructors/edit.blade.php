@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Instructor</h1>

    <!-- Check for any validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Instructor Form -->
    <form action="{{ route('instructors.update', $instructor->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- This is necessary for updating the record -->

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $instructor->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $instructor->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $instructor->phone) }}">
        </div>

        <!-- <div class="form-group">
            <label for="departments">Departments</label>
            <select name="departments[]" id="departments" class="form-control" multiple>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ in_array($department->id, old('departments', [])) ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div> -->

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
                            {{ $instructor->departments->contains($department->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="department_{{ $department->id }}">
                            {{ $department->name }}
                        </label>
                    </div>
                @endforeach
        </div>


        <div class="form-group">
            <label for="courses">Assigned Courses</label>
            <ul class="list-group">
                @forelse($instructor->courses as $course)
                    <li class="list-group-item">{{ $course->name }}</li>
                @empty
                    <li class="list-group-item text-muted">No courses assigned</li>
                @endforelse
            </ul>
        </div>      


        <button type="submit" class="btn btn-primary">Update Instructor</button>
    </form>
</div>
@endsection

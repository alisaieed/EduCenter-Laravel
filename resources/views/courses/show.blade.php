@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Course Details</h2>
                    </div>
                    <div class="card-body">
                        <!-- Course Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $course->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Description:</strong> {{ $course->description }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($course->end_date)->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <!-- Department Field -->
                        <div class="form-group mb-4">
                            <label for="department_id" class="font-weight-bold">Department</label>
                            <select name="department_id" id="department_id" class="form-control">
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $course->department_id == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Instructors List -->
                        <div class="mb-4">
                            <label class="font-weight-bold">Instructors</label>
                            <ul class="list-group">
                                @foreach($course->instructors as $instructor)
                                    <li class="list-group-item">
                                        {{ $instructor->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Students Enrolled -->
                        <h4 class="mb-3">Students Enrolled</h4>
                        <ul class="list-group">
                            @foreach($course->students as $student)
                                <li class="list-group-item">
                                    {{ $student->name }} <small class="text-muted">({{ $student->email }})</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Custom styling */
        .card-header {
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            background-color: #f9f9f9;
        }
        .list-group-item {
            border-radius: 5px;
            background-color: #fafafa;
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
        .form-check-input {
            margin-left: 10px;
        }
    </style>
@endpush

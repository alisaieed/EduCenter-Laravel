@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="container mt-4">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">Instructor Details</h2>
                        <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-dark">Profile Information</h4>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $instructor->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $instructor->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ $instructor->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Address:</strong> {{ $instructor->address ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Joined On:</strong> {{ \Carbon\Carbon::parse($instructor->created_at)->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Departments the Instructor belongs to -->
                        <h4 class="mb-4">Departments</h4>
                        @if($instructor->departments && $instructor->departments->isNotEmpty())
                            <ul class="list-group mb-4">
                                @foreach($instructor->departments as $department)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $department->name }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No courses assigned.</p>
                        @endif


                        <!-- Courses the Instructor is teaching -->
                        <h4 class="mb-4">Courses Taught</h4>
                        @if($instructor->courses && $instructor->courses->isNotEmpty())
                            <ul class="list-group mb-4">
                                @foreach($instructor->courses as $course)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $course->name }}
                                        <span class="badge bg-secondary" style="font-size: 14px; background-color: #156070!important;">
                                            {{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }} -
                                            {{ \Carbon\Carbon::parse($course->end_date)->format('d M, Y') }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No courses assigned.</p>
                        @endif

                        <!-- Students the Instructor has taught -->
                        @if($instructor->courses && $instructor->courses->isNotEmpty())
                        @php
                            $students = collect(); // Initialize an empty collection
                            foreach ($instructor->courses as $course) {
                                $students = $students->merge($course->students); // Merge students from each course
                            }
                            $students = $students->unique('id'); // Remove duplicate students
                        @endphp

                        @if($students->isNotEmpty())
                            <h4 class="mb-4">Students Taught</h4>
                            <ul class="list-group">
                                @foreach($students as $student)
                                    <li class="list-group-item">
                                        <strong>{{ $student->name }}</strong>
                                        <span class="text-muted d-block">{{ $student->email }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">No students assigned.</p>
                        @endif
                    @else
                        <p class="text-muted">No students assigned.</p>
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Styling for the card */
        .card {
            border-radius: 12px;
            overflow: hidden;
        }

        .card-header {
            border-radius: 12px 12px 0 0;
            font-size: 1.25rem;
        }

        .card-body {
            background-color: #f8f9fa;
        }

        /* List group styling */
        .list-group-item {
            background-color: #ffffff;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .list-group-item:hover {
            background-color: #f1f1f1;
        }
    </style>
@endpush

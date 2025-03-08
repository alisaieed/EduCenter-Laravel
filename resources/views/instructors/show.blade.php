@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h2>Instructor Details</h2>
                    </div>
                    
                    <div class="card-body">
                        <!-- Edit Button -->
                        <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-warning btn-sm" style="margin-bottom: 10px!important;">Edit</a>

                        <!-- Instructor Details -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ $instructor->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ $instructor->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ $instructor->phone ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Address:</strong> {{ $instructor->address ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Department:</strong> {{ $instructor->department->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Joined On:</strong> {{ \Carbon\Carbon::parse($instructor->created_at)->format('d M, Y') }}</p>
                            </div>
                        </div>

                        <!-- Courses the Instructor is teaching -->
                        <h4 class="mb-3">Courses Taught</h4>
                        @if($instructor->courses && $instructor->courses->isNotEmpty())
                            <ul class="list-group mb-4">
                                @foreach($instructor->courses as $course)
                                    <li class="list-group-item">
                                        {{ $course->name }} - {{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }} to {{ \Carbon\Carbon::parse($course->end_date)->format('d M, Y') }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No courses assigned.</p>
                        @endif

                        <!-- Students the Instructor has taught (optional section) -->
                        <h4 class="mb-3">Students Taught</h4>
                        @if($instructor->students && $instructor->students->isNotEmpty())
                            <ul class="list-group">
                                @foreach($instructor->students as $student)
                                    <li class="list-group-item">
                                        {{ $student->name }} <small class="text-muted">({{ $student->email }})</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No students assigned.</p>
                        @endif
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
    </style>
@endpush

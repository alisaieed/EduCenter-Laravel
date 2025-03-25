@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="container mt-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h2>Department Details</h2>
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h4><strong>Department Name:</strong> {{ $department->name }}</h4>
                            <p><strong>Description:</strong> {{ $department->description }}</p>
                        </div>

                        <div class="mb-4">
                            <h4><strong>Head of Department:</strong> {{ $department->headinstructor->name ?? 'N/A' }}</h4>
                            @if ($department->headOfDepartment)
                                <p><strong>Email:</strong> {{ $department->headOfDepartment->email }}</p>
                                <p><strong>Phone:</strong> {{ $department->headOfDepartment->phone ?? 'N/A' }}</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h4><strong>Instructors:</strong></h4>
                            <ul class="list-group">
                                @forelse($department->instructors as $instructor)
                                    <li class="list-group-item">
                                        <strong>{{ $instructor->name }}</strong>
                                        <p>Email: {{ $instructor->email }}</p>
                                    </li>
                                @empty
                                    <p>No instructors assigned to this department.</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-header {
            border-radius: 10px 10px 0 0;
        }
        .card-body {
            background-color: #f9f9f9;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        .list-group-item {
            border: none;
            background-color: #f9f9f9;
            padding: 10px 15px;
        }
    </style>
@endpush

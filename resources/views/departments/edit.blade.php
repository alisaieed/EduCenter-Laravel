@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Department</h1>
    
    <form action="{{ route('departments.update', $department->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $department->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="head_instructor_id" class="form-label">Head Instructor</label>
            <select name="head_instructor_id" id="head_instructor_id" class="form-control select2">
                <option value="">Select Head Instructor</option>
                @foreach ($instructors as $instructor)
                    <option value="{{ $instructor->id }}" 
                        {{ $department->head_instructor_id == $instructor->id ? 'selected' : '' }}>
                        {{ $instructor->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <h3 class="mb-3">Instructors in this Department</h3>
        <ul class="list-group mb-3">
            @foreach ($department->instructors as $instructor)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $instructor->name }}
                    <form action="{{ route('departments.unassignInstructor', [$department->id, $instructor->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <!-- Assign Instructor Button -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#assignInstructorModal">
            Assign Instructor
        </button>

        <!-- Assign Instructor Modal -->
        <div class="modal fade" id="assignInstructorModal" tabindex="-1" aria-labelledby="assignInstructorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Instructor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('departments.assignInstructor', $department->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="instructorSelect" class="form-label">Select Instructor</label>
                                <select class="form-control select2" id="instructorSelect" name="instructor_id">
                                    <option value="">Search for an instructor...</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Assign</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Department</button>
    </form>
</div>

<!-- Include Select2 for search functionality -->
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Search...",
                allowClear: true
            });
        });
    </script>
@endsection
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Edit Instructor</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('instructors.update', $instructor->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $instructor->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $instructor->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $instructor->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label"><strong>Assigned Departments</strong></label>
            <ul class="list-group">
                @foreach($instructor->departments as $department)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $department->name }}
                        <form action="{{ route('instructors.unassignDepartment', $instructor) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="department_id" value="{{ $department->id }}">
                            <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#assignDepartmentModal">
            Assign to Department
        </button>

        <div class="mb-3 mt-4">
            <label class="form-label">Assigned Courses</label>
            <ul class="list-group">
                @foreach($instructor->courses as $course)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $course->name }}
                        <form action="{{ route('instructors.unassignCourse', [$instructor->id, $course->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Unassign</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#assignCourseModal">
            Assign to Course
        </button>

        <button type="submit" class="btn btn-success mt-4">Update Instructor</button>
    </form>
</div>

<!-- Assign Department Modal -->
<div class="modal fade" id="assignDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Instructor to Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchDepartment" class="form-control mb-2" placeholder="Search Department...">
                <form action="{{ route('instructors.assignDepartment', $instructor->id) }}" method="POST">
                    @csrf
                    <select class="form-select" id="departmentSelect" name="department_id">
                        <option value="" disabled selected>-- Choose Department --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success mt-3">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Assign Course Modal -->
<div class="modal fade" id="assignCourseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchCourse" class="form-control mb-2" placeholder="Search Course...">
                <form action="{{ route('instructors.assignCourse', $instructor->id) }}" method="POST">
                    @csrf
                    <select class="form-select" id="courseSelect" name="course_id">
                        <option value="" disabled selected>-- Choose Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Assign</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filterDropdown(inputId, selectId) {
        document.getElementById(inputId).addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let options = document.getElementById(selectId).options;
            for (let i = 0; i < options.length; i++) {
                let text = options[i].text.toLowerCase();
                options[i].style.display = text.includes(filter) ? "block" : "none";
            }
        });
    }

    filterDropdown("searchDepartment", "departmentSelect");
    filterDropdown("searchCourse", "courseSelect");
</script>
@endsection

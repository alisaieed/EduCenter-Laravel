@extends('layouts.app')

@section('content')
    <h1>Students</h1>
    {{-- Search and Filter Form --}}
    <form action="{{ route('students.index') }}" method="GET" class="mb-4">
        <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email"
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <select name="course" class="form-control">
                        <option value="">Filter by Course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ request('course') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
    </form>

    <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add Student</a>
    <button onclick="printTable()" class="btn btn-secondary mb-3">Print Table</button>

    <table id="studentsTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Courses</th>
                <th>Balance Due</th>
                <th>Register to Course</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                <td>
                    <a href="{{ route('students.show', $student->id) }}" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                        {{ $student->name }}
                    </a>
                 </td>
                 <td>
                    <a href="{{ route('students.show', $student->id) }}" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                        {{ $student->email }}
                    </a>
                 </td>
                 <td>
                    <a href="{{ route('students.show', $student->id) }}" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                        {{ $student->phone_number }}
                    </a>
                 </td>
                <td>
                        @if ($student->courses->isEmpty())
                            <span class="text-muted">No courses assigned</span>
                        @else
                            @php $totalCost = 0; @endphp
                                 @foreach ($student->courses as $course)
                                <span class="badge bg-info">{{ $course->name }}
                                    <!-- - ${{ number_format($course->cost, 2) }} -->
                                </span>
                                @php $totalCost += $course->cost; @endphp
                                @endforeach
                                <span class="badge bg-info">Total: ${{ number_format($totalCost, 2) }}  </span>
                                <!-- <strong>Total: ${{ number_format($totalCost, 2) }}</strong> -->
                        @endif
                </td>
                    <td>
                    <span class="badge {{ $student->remaining_balance > 0 ? 'bg-info-red' : 'bg-info' }}">
                        ${{ number_format($student->remaining_balance, 2) }}
                    </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#registerCourseModal-{{ $student->id }}">
                            Register to Course
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">View</a>
                        <!-- <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>


                        <!-- Register Course Modal -->
                        <div class="modal fade" id="registerCourseModal-{{ $student->id }}" tabindex="-1" aria-labelledby="registerCourseModalLabel-{{ $student->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="registerCourseModalLabel-{{ $student->id }}">Register to a Course</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('students.updateCourses', $student->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="searchCourse-{{ $student->id }}">Search Course:</label>
                                                <input type="text" id="searchCourse-{{ $student->id }}" class="form-control" placeholder="Type to search..." onkeyup="filterCourses({{ $student->id }})">
                                            </div>

                                            <div class="mb-3">
                                                <label for="courseSelect-{{ $student->id }}">Select Course:</label>
                                                <select name="courses[]" id="courseSelect-{{ $student->id }}" class="form-select">
                                                    @foreach($courses as $course)
                                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-success">Register</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>



            @endforeach
        </tbody>
    </table>
@endsection


@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        window.printTable = function() {
            let tableElement = document.getElementById('studentsTable');

            if (!tableElement) {
                console.error("Error: 'studentsTable' not found in the DOM!");
                alert("Error: The students table is missing from the page.");
                return;
            }

            // Clone the table to avoid modifying the original one
            let clonedTable = tableElement.cloneNode(true);

            // Remove the "Register to Course" and "Actions" columns
            let headerRow = clonedTable.querySelector("thead tr");
            let rows = clonedTable.querySelectorAll("tbody tr");

            let removeColumns = [5, 6];
            removeColumns.reverse().forEach(index => {
                if (headerRow) headerRow.deleteCell(index);
                rows.forEach(row => row.deleteCell(index));
            });

            // Prepare new print window
            let newWindow = window.open('', '', 'width=900,height=700');
            newWindow.document.write(`
                <html>
                <head>
                    <title>Print Students Table</title>
                    <style>
                        body { font-family: Arial, sans-serif; padding: 20px; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid black; padding: 10px; text-align: left; font-size: 14px; }
                        th { background-color: #f2f2f2; }
                        ul { padding-left: 20px; margin: 5px 0; }
                    </style>
                </head>
                <body>
                    <h2 style="text-align:center;">Students List</h2>
                    ${clonedTable.outerHTML}
                    <script>
                        window.onload = function() {
                            window.print();
                        };
                    <\/script>
                </body>
                </html>
            `);
            newWindow.document.close();
        }
    });
</script>
<script>
    function filterCourses() {
        let searchInput = document.getElementById('searchCourse').value.toLowerCase();
        let dropdown = document.getElementById('courseSelect');

        for (let i = 0; i < dropdown.options.length; i++) {
            let text = dropdown.options[i].text.toLowerCase();
            dropdown.options[i].style.display = text.includes(searchInput) ? "block" : "none";
        }
    }
</script>
@endsection


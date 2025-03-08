@extends('layouts.app')

@section('content')
    <h1>Courses</h1>

    <!-- Search and Filter Form -->
    <form method="GET" action="{{ route('courses.index') }}" class="mb-3" style="margin-bottom: 20px!important;">
        <div class="row">
            <!-- Search by Course Name -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Course Name" value="{{ request()->input('search') }}">
            </div>

            <!-- Filter by Month -->
            <div class="col-md-4">
                <select name="month" class="form-control">
                    <option value="">Filter by Month</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ request()->input('month') == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromFormat('m', $month)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <!-- Print Button -->
        <!-- Add Course Button -->
    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">Add Course</a>
    <button onclick="printTable()" class="btn btn-secondary mb-3">Print Table</button>

    <!-- Courses Table -->
    <table class="table table-striped" id="coursesTable">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Cost</th>
                <th>Department</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Number of Students</th>
                <th>Number of Instructors</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr>
                <td>
                    <a href="{{ route('courses.show', $course->id) }}" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                        {{ $course->name }}
                    </a>
                 </td>
                 <td>
                    <a href="{{ route('courses.show', $course->id) }}" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                        {{ $course->cost }}
                    </a>
                 </td>                  
                 <td>
                    <a href="{{ route('courses.show', $course->id) }}" style="display: block; width: 100%; height: 100%; text-decoration: none; color: inherit;">
                        {{ $course->department->name }}
                    </a>
                 </td>                    
                    <td>{{ \Carbon\Carbon::parse($course->start_date)->format('d M, Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($course->end_date)->format('d M, Y') }}</td>
                    <td>{{ $course->students->count() }}</td>
                    <td>{{ $course->instructors->count() }}</td>
                    <td>
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                        <!-- <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
    // Print table function
    function printTable() {
        var table = document.getElementById('coursesTable');
        var printContents = table.outerHTML;
        var originalContents = document.body.innerHTML;

        // Clone the table
        var clonedTable = table.cloneNode(true);

        // Remove the 7th column (index 6) from the cloned table
        let headerRow = clonedTable.querySelector("thead tr");
        let rows = clonedTable.querySelectorAll("tbody tr");

        let removeColumns = [6]; // 7th column (0-based index 6)

        removeColumns.reverse().forEach(index => {
            if (headerRow) headerRow.deleteCell(index); // Remove from header
            rows.forEach(row => row.deleteCell(index)); // Remove from each row
        });

        // Get the updated HTML of the cloned table without the "Actions" column
        printContents = clonedTable.outerHTML;

        // Print the table without the "Actions" column
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    </script>



@endsection

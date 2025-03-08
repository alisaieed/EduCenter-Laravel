@extends('layouts.app')

@section('content')
    <h1>Instructors</h1>


<!-- Search and Filter Form -->
    <form action="{{ route('instructors.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by Name, Email, or Course" value="{{ request('search') }}" />
            </div>

            <div class="col-md-4">
                <select name="department" class="form-control mx-2">
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Apply Filter</button>
                <button type="reset" class="btn btn-secondary" onclick="resetFilters()">Reset</button>
            </div>
        </div>
    </form>


    <a href="{{ route('instructors.create') }}" class="btn btn-primary mb-3">Add Instructor</a>
    <!-- Print Button -->
    <button onclick="printTable()" class="btn btn-secondary mb-3">Print Table</button>

    <table id="instructorsTable" class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Assigned Courses</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td>{{ $instructor->email }}</td>
                    <td>{{ $instructor->phone }}</td>
                    <td>
                        @foreach($instructor->departments as $department)
                            <span>{{ $department->name }}</span><br>
                        @endforeach
                    </td>
                    <td>{{ $instructor->courses->count() }}</td>
                    <td>
                        <a href="{{ route('instructors.show', $instructor->id) }}" class="btn btn-info btn-sm">View</a>
                        <!-- <a href="{{ route('instructors.edit', $instructor->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $instructors->links() }}
    </div>

@endsection

@section('scripts')
    <script>
        // Reset the filters to the default state
        function resetFilters() {
            window.location.href = '{{ route('instructors.index') }}';
        }

        // Print table function
        function printTable() {
            var table = document.getElementById('instructorsTable');
            var printContents = table.outerHTML;
            var originalContents = document.body.innerHTML;

            // Clone the table to manipulate it
            var clonedTable = table.cloneNode(true);
            var headers = clonedTable.querySelector("thead tr");
            var rows = clonedTable.querySelectorAll("tbody tr");

            // Remove the "Actions" column (index 5, 0-based)
            var removeColumns = [5]; // Index of the Actions column (0-based index)
            removeColumns.reverse().forEach(index => {
                if (headers) headers.deleteCell(index); // Remove from header row
                rows.forEach(row => row.deleteCell(index)); // Remove from body rows
            });

            // Create a new div to hold the cloned table and print it
            var printDiv = document.createElement('div');
            printDiv.innerHTML = clonedTable.outerHTML;

            // Replace the body content with the table content for printing
            document.body.innerHTML = printDiv.innerHTML;

            window.print(); // Trigger the print dialog

            // Restore the original content after printing
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection

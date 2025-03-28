@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('content')
    <div class="container">
        <h1 class="mb-4">Dashboard</h1>



        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Students</h5>
                        <h2>{{ $totalStudents }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5>Total Courses</h5>
                        <h2>{{ $totalCourses }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5>Total Instructors</h5>
                        <h2>{{ $totalInstructors }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Students -->
        <h3 class="mt-4">Recent Student Registrations</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentStudents as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Recent Enrollments -->
        <h3 class="mt-4">Recent Course Enrollments</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Students Enrolled</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentEnrollments as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->students->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <canvas id="enrollmentChart" width="400" height="200"></canvas>

<script>
    var ctx = document.getElementById('enrollmentChart').getContext('2d');
    var enrollmentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($recentEnrollments->pluck('name')),
            datasets: [{
                label: 'Students Enrolled',
                data: @json($recentEnrollments->pluck('students')->map->count()),
                backgroundColor: '#CAA8F5',
            }]
        }
    });
</script>


@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> <!-- Optional Custom CSS -->
</head>
<body>

    <!-- Navigation Menu -->
    <div class="container mt-3">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('students.index') }}">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('courses.index') }}">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('instructors.index') }}">Instructors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('departments.index') }}">Departments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="{{ route('certificates.index') }}">Certificates</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
 
    @yield('scripts')

</body>
</html>

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div id=printable-area>
    <div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <h3 class="mb-0">Student Details</h3>
    <div class="d-flex gap-2 align-items-center">
            <button class="btn btn-light btn-sm align-self-center" onclick="printDetails()">
                <i class="bi bi-printer"></i> Print Details
            </button>
            
            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $student->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Email:</strong> {{ $student->email }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Address:</strong> {{ $student->address }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Phone:</strong> {{ $student->phone_number }}</p>
                </div>
            </div>

            <h4 class="mt-4">Registered Courses</h4>
            <ul class="list-group">
                @foreach($student->courses as $course)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center w-100">
                            <span class="fw-bold me-3">{{ $course->name }}</span>
                            <span class="text-muted me-3"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($course->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($course->end_date)->format('d M Y') }}</span>
                            <span class="text-success fw-semibold me-3"><i class="bi bi-cash"></i> ${{ number_format($course->cost, 2) }}</span>
                        </div>
                                    <!-- Unregister Button Form -->
                        <form action="{{ route('students.removeCourse', [$student->id, $course->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm me-3">Unregister</button>
                        </form>
                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm">
                            View
                        </a>
                    </li>
                @endforeach
            </ul>


            <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#registerCourseModal">
                Register to Course
            </button>
        </div>

        <div class="card-body">
            <h4>Payments</h4>
            <div class="row mb-3" style="margin-bottom: 40px!importatnt;">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-3 text-center bg-light">
                        <h6 class="fw-bold" style="color: #4f68bb;">Total Course Cost</h6>
                        <p class="fs-5 mb-0">${{ number_format($student->total_course_cost, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-3 text-center bg-light">
                        <h6 class="text-success fw-bold">Amount Paid</h6>
                        <p class="fs-5 mb-0">${{ number_format($student->total_paid, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-3 text-center bg-light">
                        <h6 class="text-danger fw-bold">Remaining Balance</h6>
                        <p class="fs-5 mb-0">${{ number_format($student->remaining_balance, 2) }}</p>
                    </div>
                </div>
            </div>

            <button id="showPaymentsBtn" class="btn btn-primary mb-3">Show Payments</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                Register a Payment
            </button>
            <!-- Refund Button -->
            <button class="button btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#refundModal">Refund</button>

                <!-- Payments Table (Initially Hidden) -->
                <div id="paymentsSection" style="display: none;">
                    <h3>Payments</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student->payments as $payment)
                                <tr>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->created_at->format('Y-m-d') }}</td> <!-- You can format the date as needed -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            <!-- Refund Modal -->
            <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('payments.refund', $student->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="refundAmount" class="form-label">Refund Amount:</label>
                                    <input type="number" step="0.01" min="0.01" class="form-control" name="amount" required>
                                </div>
                                <button type="submit" class="btn btn-success">Confirm Refund</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Submit Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">

                    <div class="mb-3">
                        <label for="amount">Payment Amount:</label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="payment_date">Payment Date:</label>
                        <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register Course Modal -->
<div class="modal fade" id="registerCourseModal" tabindex="-1" aria-labelledby="registerCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerCourseModalLabel">Register to a Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('students.updateCourses', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="searchCourse">Search Course:</label>
                        <input type="text" id="searchCourse" class="form-control" placeholder="Type to search..." onkeyup="filterCourses()">
                    </div>

                    <div class="mb-3">
                        <label for="courseSelect">Select Course:</label>
                        <select name="courses[]" id="courseSelect" class="form-select">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success" style="margin: 10px;">Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- JavaScript for Toggling the Payments Section -->
    <script>
        // Get the button and the payments section
        const showPaymentsBtn = document.getElementById('showPaymentsBtn');
        const paymentsSection = document.getElementById('paymentsSection');

        // Add event listener to toggle the visibility of the payments section
        showPaymentsBtn.addEventListener('click', function() {
            if (paymentsSection.style.display === 'none') {
                paymentsSection.style.display = 'block';
                showPaymentsBtn.textContent = 'Hide Payments';  // Change button text when showing payments
            } else {
                paymentsSection.style.display = 'none';
                showPaymentsBtn.textContent = 'Show Payments';  // Change button text back to "Show Payments"
            }
        });
    </script>

<script>
    // Set the payment_date input to today's date
    document.getElementById('payment_date').value = new Date().toISOString().split('T')[0];

    function filterCourses() {
        let searchInput = document.getElementById('searchCourse').value.toLowerCase();
        let dropdown = document.getElementById('courseSelect');

        for (let i = 0; i < dropdown.options.length; i++) {
            let text = dropdown.options[i].text.toLowerCase();
            dropdown.options[i].style.display = text.includes(searchInput) ? "block" : "none";
        }
    }
</script>
<script>
    function printDetails() {
        var printableContent = document.getElementById('printable-area').innerHTML; // Select the main content
        var originalContent = document.body.innerHTML; // Backup the original page content

        document.body.innerHTML = `
            <html>
                <head>
                    <title>Student Details</title>
                    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .container { max-width: 800px; margin: auto; }
                        .card { border: 1px solid #ddd; padding: 20px; }
                        .hidden-print { display: none; } /* Hide buttons */
                    </style>
                </head>
                <body>
                    ${printableContent}
                </body>
            </html>
        `;

        window.print();
        document.body.innerHTML = originalContent; // Restore the original page after printing
        location.reload(); // Reload the page to restore event listeners
    }
</script>

<script>
    function printDetails() {
        var printContent = document.getElementById('printable-area').innerHTML;
        var originalContent = document.body.innerHTML;

        var printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <title>Student Details</title>
                <link rel="stylesheet" href="{{ asset('css/app.css') }}">
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    .container { max-width: 800px; margin: auto; }
                    .card { border: 1px solid #ddd; padding: 20px; }
                    .btn { display: none; }
                </style>
            </head>
            <body>
                ${printContent}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
</script>

@endsection

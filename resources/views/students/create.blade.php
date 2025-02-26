@extends('layouts.app')

@section('content')
<h1>Create Student</h1>
<form action="{{ route('students.store') }}" method="POST">
    @csrf

    <!-- Name Field -->
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <!-- Email Field -->
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <!-- Date of Birth Field -->
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" required>
    </div>

    <!-- Address Field -->
    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control" required></textarea>
    </div>

    <!-- Phone Number Field -->
    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Create Student</button>
</form>
@endsection

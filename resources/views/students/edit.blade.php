@extends('layouts.app')

@section('content')
<h1>Edit Student</h1>
<form action="{{ route('students.update', $student->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Name Field -->
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $student->name) }}" required>
    </div>

    <!-- Email Field -->
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $student->email) }}" required>
    </div>

    <!-- Date of Birth Field -->
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob', $student->dob) }}" required>
    </div>

    <!-- Address Field -->
    <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control" required>{{ old('address', $student->address) }}</textarea>
    </div>

    <!-- Phone Number Field -->
    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $student->phone_number) }}" required>
    </div>

    <button type="submit" class="btn btn-primary" style="padding: 10px 20px; margin: 15px;">Update Student</button>
</form>
@endsection

@extends('layouts.app')

@section('content')
    <h1>{{ $instructor->name }}</h1>
    <p>Email: {{ $instructor->email }}</p>
    <a href="{{ route('instructors.index') }}" class="btn btn-primary">Back to Instructors</a>
@endsection

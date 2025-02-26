<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Instructor;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalCourses = Course::count();
        $totalInstructors = Instructor::count();

        $recentStudents = Student::latest()->take(5)->get();
        $recentEnrollments = Course::with('students')->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalStudents', 'totalCourses', 'totalInstructors', 'recentStudents', 'recentEnrollments'
        ));
    }
}

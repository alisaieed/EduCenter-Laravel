<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Instructor;
use App\Models\Department;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CourseController extends Controller
{
    
// CoursesController.php


    public function index(Request $request)
    {
        $courses = Course::query();

        // Search by course name
        if ($request->has('search') && $request->search != '') {
            $courses->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by month
        if ($request->has('month') && $request->month != '') {
            $courses->whereMonth('start_date', $request->month);
        }

        // Get the filtered courses
        $courses = $courses->get();

        return view('courses.index', compact('courses'));
    }


    public function create()
    {
        // Get all instructors, departments, and certificates
        $instructors = Instructor::all();
        $departments = Department::all();
        $certificates = Certificate::all();
        return view('courses.create', compact('instructors', 'departments', 'certificates'));
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
            'description' => 'required',
            'department_id' => 'required|exists:departments,id',
            'instructor_ids' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'certificate_id' => 'nullable|exists:certificates,id'
        ]);
    
        // Create the course
        $course = Course::create($request->all());
    
        // Attach instructors (many-to-many relationship)
        $course->instructors()->sync($request->instructor_ids);
    
        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    public function show(Course $course)
    {
        $instructors = Instructor::all();
        $departments = Department::all();
        $certificates = Certificate::all();
        return view('courses.show', compact('course', 'instructors', 'departments', 'certificates'));
    }

    public function edit(Course $course)
    {
        $instructors = Instructor::all();
        $departments = Department::all();
        $certificates = Certificate::all();

        return view('courses.edit', compact('course', 'instructors', 'departments', 'certificates'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $student->updateTotalCourseCost(); // Update total cost
        $student->getRemainingBalanceAttribute();
        
        // Validate the data
        $request->validate([
            'name' => 'required',
            'cost' => 'required',
            'description' => 'required',
            'department_id' => 'required|exists:departments,id',
            'instructors' => 'required|array',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'certificate_id' => 'nullable|exists:certificates,id',
        ]);
    
        // Update the course details
        $course->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'description' => $request->description,
            'instructors' => $request->instructors,
            'department_id' => $request->department_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'certificate_id' => $request->certificate_id,
        ]);
    
        // Update the instructors
        $course->instructors()->sync($request->instructors);
    
        // Redirect to the courses index page with a success message
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }
    

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index');
    }
}

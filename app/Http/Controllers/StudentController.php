<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function removeCourse($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        $course = Course::findOrFail($courseId);

        // Detach the course from the student
        $student->courses()->detach($courseId);

        $student->updateTotalCourseCost();

        // Redirect back with a success message
        return redirect()->route('students.show', $student->id)->with('success', 'Course removed successfully.');
    }


    public function updateCourses(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->courses()->attach($request->courses); // Add new courses without removing existing ones

        $student->updateTotalCourseCost();

        return redirect()->route('students.show', $id)->with('success', 'Courses updated successfully');
    }


    // Show the list of students
    public function index(Request $request)
    {
        $query = Student::with('courses'); // Start the query

        // Search by name or email
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('email', 'LIKE', "%{$request->search}%");
            });
        }

        // Filter by course
        if ($request->has('course') && !empty($request->course)) {
            $query->whereHas('courses', function ($q) use ($request) {
                $q->where('courses.id', $request->course);
            });
        }

        $students = $query->get();
        $courses = Course::all(); // Get all courses for filtering

        return view('students.index', compact('students', 'courses'));
    }


    // Show the form to create a new student
    public function create()
    {
        return view('students.create');
    }

    // Store the new student in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students',
        ]);

        Student::create($request->all());
        return redirect()->route('students.index');
    }

    public function show($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        $courses = Course::all(); // Fetch all available courses

        return view('students.show', compact('student', 'courses'));
    }

    public function edit($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        $courses = Course::all(); // Fetch all available courses

        return view('students.edit', compact('student', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'courses' => 'array|exists:courses,id', // Ensure selected courses exist
        ]);

        // Update student details
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'courses' => $request->courses
        ]);

        // Sync courses (many-to-many relationship)
        $student->courses()->sync($request->courses);

        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

}

<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;

use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function updateCourses(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->courses()->sync($request->courses); // Sync selected courses

        return redirect()->route('students.show', $id)->with('success', 'Courses updated successfully');
    }


    // Show the list of students
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
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
        ]);
    
        // Sync courses (many-to-many relationship)
        $student->courses()->sync($request->courses);
    
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }
    
}

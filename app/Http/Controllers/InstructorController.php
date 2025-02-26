<?php
namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::all();
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        $departments = Department::all();
        $courses = Course::all(); // Fetch all courses
        return view('instructors.create', compact('departments', 'courses'));
    }

    public function store(Request $request)
    {
        // Validate form input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email',
            'phone' => 'nullable|string|max:255',
            'departments' => 'nullable|array|exists:departments,id',  // Make sure department_id exists in departments table
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',  // Ensure courses exist in courses table
        ]);
    
        // Store the instructor
        $instructor = Instructor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'department_id' => $validated['department_id'] ?? null,
        ]);
    
        // Attach courses if selected
        if (isset($validated['courses'])) {
            $instructor->courses()->sync($validated['courses']);
        }
    
        if ($request->has('departments')) {
            $instructor->departments()->attach($request->departments);
        }

        // Redirect back or to a specific page
        return redirect()->route('instructors.index')->with('success', 'Instructor created successfully.');
    }

    public function show(Instructor $instructor)
    {
        return view('instructors.show', compact('instructor'));
    }

    public function edit($id)
    {
        $instructor = Instructor::with('departments')->findOrFail($id);        $departments = Department::all(); // Get all departments
        $courses = Course::all(); // Get all courses
    
        return view('instructors.edit', compact('instructor', 'departments', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:instructors,email,' . $instructor->id,
            'phone' => 'nullable|string',
            'departments' => 'array',
            'departments.*' => 'exists:departments,id',
        ]);
    
        $instructor->update($request->only('name', 'email', 'phone'));
    
        $instructor->departments()->sync($request->departments ?? []);
    
        return redirect()->route('instructors.index')->with('success', 'Instructor updated successfully.');
    }
    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return redirect()->route('instructors.index');
    }
}

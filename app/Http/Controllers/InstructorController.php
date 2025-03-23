<?php
namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Department;
use App\Models\Course;
use Illuminate\Http\Request;

class InstructorController extends Controller
{

    public function assignCourse(Request $request, Instructor $instructor)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        if (!$instructor->courses()->where('courses.id', $request->course_id)->exists()) {
            $instructor->courses()->attach($request->course_id);
        }

        return redirect()->back()->with('success', 'Instructor assigned to course successfully.');
    }

    public function unassignCourse(Instructor $instructor, $course_id)
    {
    $instructor->courses()->detach($course_id);
    return redirect()->back()->with('success', 'Instructor removed from course.');
    }


    public function assignDepartment(Request $request, Instructor $instructor)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        // Avoid duplicate assignment (Fixed the ambiguous column issue)
        if (!$instructor->departments()->where('departments.id', $request->department_id)->exists()) {
            $instructor->departments()->attach($request->department_id);
        }

        return redirect()->back()->with('success', 'Instructor assigned to department successfully.');
    }

    public function unassignDepartment(Request $request, Instructor $instructor)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $instructor->departments()->detach($request->department_id);

        return redirect()->back()->with('success', 'Instructor unassigned from department successfully.');
    }

    public function index(Request $request)
    {
        $query = Instructor::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereHas('courses', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Department filter functionality
        if ($request->has('department') && !empty($request->department)) {
            $departmentId = $request->input('department');
            $query->whereHas('departments', function($q) use ($departmentId) {
                $q->where('departments.id', $departmentId);  // Specify table name for the ID
            });
        }

        $instructors = $query->with(['departments', 'courses'])->paginate(10);

        // Get all departments for the filter dropdown
        $departments = Department::all();

        return view('instructors.index', compact('instructors', 'departments'));
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

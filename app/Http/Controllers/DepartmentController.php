<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Instructor;
use App\Models\Course;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'head_instructor_id' => 'required|exists:instructors,id',
            'instructors' => 'array|exists:instructors,id', // Ensure instructors are valid IDs
        ]);

        // Update department
        $department->update([
            'name' => $request->name,
            'head_instructor_id' => $request->head_instructor_id,
        ]);

        // Sync instructors in the department (many-to-many relationship)
        $department->instructors()->sync($request->instructors);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully');
    }

    // Show a list of departments
    public function index()
    {
        // Fetch all departments
        $departments = Department::all();

        // Pass the departments to the view
        return view('departments.index', compact('departments'));
    }

    public function edit($id)
    {
        $department = Department::with('instructors')->findOrFail($id);
        $instructors = Instructor::all(); // Fetch all instructors
    
        return view('departments.edit', compact('department', 'instructors'));
    }
    
    
    // Show the form to create a new department
    public function create()
    {
        // Fetch all instructors to select from
        $instructors = Instructor::all();

        // Pass the instructors to the view
        return view('departments.create', compact('instructors'));
    }

    // Store a new department in the database
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'head_instructor_id' => 'required|exists:instructors,id',
            'instructors' => 'nullable|array',
            'instructors.*' => 'exists:instructors,id',
        ]);

        // Create a new department
        $department = Department::create([
            'name' => $request->name,
            'head_instructor_id' => $request->head_instructor_id,
        ]);

        // Attach instructors to the department
        if ($request->has('instructors')) {
            $department->instructors()->attach($request->instructors);
        }

        // Redirect to the department index page with a success message
        return redirect()->route('departments.index')->with('success', 'Department created successfully');
    }
    public function show($id)
    {
        $department = Department::with('instructors')->findOrFail($id);
        $instructors = Instructor::all(); // Fetch all instructors
    
        return view('departments.show', compact('department', 'instructors'));
    }

    public function destroy($id)
     {
         $department = Department::findOrFail($id);
         $department->delete();

         return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
      }

    
    

}

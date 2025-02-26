<?php
namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Course;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::all();
        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('certificates.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        $path = $request->file('file')->store('certificates');
        Certificate::create([
            'course_id' => $request->course_id,
            'file_path' => $path,
        ]);

        return redirect()->route('certificates.index');
    }

    public function show(Certificate $certificate)
    {
        return view('certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        $courses = Course::all();
        return view('certificates.edit', compact('certificate', 'courses'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('certificates');
            $certificate->update([
                'file_path' => $path,
                'course_id' => $request->course_id,
            ]);
        } else {
            $certificate->update(['course_id' => $request->course_id]);
        }

        return redirect()->route('certificates.index');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('certificates.index');
    }
}

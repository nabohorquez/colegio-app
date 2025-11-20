<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Student;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with(["creator", "student"])->latest()->paginate(10);
        return view("school_admin.activities.index", compact("activities"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('first_name')->get();
        $subjects = Topic::pluck('title');

        return view("school_admin.activities.create", compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "student_id" => "nullable|exists:students,id",
            "subject" => "nullable|string|max:255",
            "description" => "nullable|string",
            "resource_assignment" => "nullable|string",
            "example_assignment" => "nullable|string",
        ]);

        Activity::create([
            "title" => $request->title,
            "description" => $request->description,
            "student_id" => $request->student_id,
            "subject" => $request->subject,
            "resource_assignment" => $request->resource_assignment,
            "example_assignment" => $request->example_assignment,
            "created_by" => Auth::id(),
        ]);

        return redirect()->route("activities.index")
            ->with("success", "Actividad creada exitosamente.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return view("school_admin.activities.show", compact("activity"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $students = Student::orderBy('first_name')->get();
        $subjects = Topic::pluck('title');

        return view("school_admin.activities.edit", compact("activity", "students", "subjects"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            "title" => "required|string|max:255",
            "student_id" => "nullable|exists:students,id",
            "subject" => "nullable|string|max:255",
            "description" => "nullable|string",
            "resource_assignment" => "nullable|string",
            "example_assignment" => "nullable|string",
        ]);

        $activity->update($request->all());

        return redirect()->route("activities.index")
            ->with("success", "Actividad actualizada exitosamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return redirect()->route("activities.index")
            ->with("success", "Actividad eliminada exitosamente");
    }
}

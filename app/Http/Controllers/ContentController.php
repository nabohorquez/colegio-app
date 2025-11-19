<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::with(['subject', 'creator'])->latest()->paginate(15);
        return view('school_admin.contents.index', compact('contents'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();
        $academicPeriods = ['2025-I', '2025-II', '2026-I', '2026-II'];
        return view('school_admin.contents.create', compact('subjects', 'academicPeriods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'academic_period' => 'required|string|max:50',
        ]);

        Content::create([
            'title' => $request->title,
            'description' => $request->description,
            'subject_id' => $request->subject_id,
            'academic_period' => $request->academic_period,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('school.contents.index')
            ->with('success', 'Contenido creado correctamente.');
    }

    public function show(Content $content)
    {
        $content->load(['subject', 'creator']);
        return view('school_admin.contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        $subjects = Subject::orderBy('name')->get();
        $academicPeriods = ['2025-I', '2025-II', '2026-I', '2026-II'];
        return view('school_admin.contents.edit', compact('content', 'subjects', 'academicPeriods'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
            'academic_period' => 'required|string|max:50',
        ]);

        $content->update($request->all());

        return redirect()->route('school.contents.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(Content $content)
    {
        $content->delete();
        return redirect()->route('school.contents.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }
}

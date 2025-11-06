<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = Topic::with('creator')->orderBy('created_at', 'desc')->get();
        return view('school_admin.topics.index', compact('topics'));
    }

    public function create()
    {
        return view('school_admin.topics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $topic = Topic::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('topics.index')
            ->with('success', 'Topic created successfully.');
    }

    public function show(Topic $topic)
    {
        return view('school_admin.topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        return view('school_admin.topics.edit', compact('topic'));
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $topic->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('topics.index')
            ->with('success', 'Topic updated successfully.');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('topics.index')
            ->with('success', 'Topic deleted successfully.');
    }
}
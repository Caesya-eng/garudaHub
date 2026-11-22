<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['user', 'bids'])->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'budget'      => 'required|numeric|min:0',
            'deadline'    => 'nullable|date',
        ]);

        // Sanitasi input teks & gunakan ID user yang sedang login
        Project::create([
            'user_id'     => Auth::id(),
            'title'       => strip_tags($validated['title']),
            'description' => strip_tags($validated['description']),
            'budget'      => $validated['budget'],
            'deadline'    => $validated['deadline'] ?? null,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dipublikasikan!');
    }

    public function show(Project $project)
    {
        $project->load(['user', 'bids.user']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'budget'      => 'required|numeric|min:0',
            'deadline'    => 'nullable|date',
            'status'      => 'required|in:open,in_progress,completed,closed',
        ]);

        $project->update([
            'title'       => strip_tags($validated['title']),
            'description' => strip_tags($validated['description']),
            'budget'      => $validated['budget'],
            'deadline'    => $validated['deadline'] ?? null,
            'status'      => $validated['status'],
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Data proyek berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dihapus!');
    }
}
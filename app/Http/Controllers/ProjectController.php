<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::with(['user', 'bids'])->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')->get();
        if ($clients->isEmpty()) {
            $clients = User::all();
        }
        return view('projects.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'budget'      => 'required|numeric|min:0',
            'deadline'    => 'nullable|date',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dipublikasikan!');
    }

    public function show(Project $project)
    {
        $project->load(['user', 'bids.user']);
        $freelancers = User::where('role', 'freelancer')->get();
        if ($freelancers->isEmpty()) {
            $freelancers = User::all();
        }
        return view('projects.show', compact('project', 'freelancers'));
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

        $project->update($validated);

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
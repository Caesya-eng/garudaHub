<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'score'  => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $project->ratings()->create([
            'user_id' => Auth::id(),
            'score'   => $validated['score'],
            'review'  => isset($validated['review']) ? strip_tags($validated['review']) : null,
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Rating dan ulasan berhasil ditambahkan!');
    }
}
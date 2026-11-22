<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'amount'   => 'required|numeric|min:0',
            'proposal' => 'required|string',
        ]);

        $project->bids()->create([
            'user_id'  => Auth::id(),
            'amount'   => $validated['amount'],
            'proposal' => strip_tags($validated['proposal']),
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Penawaran (bid) berhasil dikirim!');
    }

    public function accept(Bid $bid)
    {
        Bid::where('project_id', $bid->project_id)->update(['status' => 'rejected']);
        $bid->update(['status' => 'accepted']);
        $bid->project->update(['status' => 'in_progress']);

        return redirect()->route('projects.show', $bid->project_id)
            ->with('success', 'Penawaran diterima! Proyek kini berstatus In Progress.');
    }

    public function destroy(Bid $bid)
    {
        $projectId = $bid->project_id;
        $bid->delete();

        return redirect()->route('projects.show', $projectId)
            ->with('success', 'Penawaran berhasil dihapus.');
    }
}
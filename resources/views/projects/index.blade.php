@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Daftar Proyek Lelang IT</h3>
    <span class="text-muted">Total: {{ $projects->count() }} proyek</span>
</div>

<div class="row">
    @forelse($projects as $project)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $project->title }}</h5>
                        <span class="badge bg-info text-dark text-uppercase">{{ str_replace('_', ' ', $project->status) }}</span>
                    </div>
                    <p class="text-muted small mb-2">
                        Klien: <strong>{{ $project->user->name }}</strong> |
                        Deadline: {{ $project->deadline ?? '-' }}
                    </p>
                    <p class="card-text">{{ Str::limit($project->description, 120) }}</p>
                    <p class="fw-bold text-success mb-0">
                        Anggaran: Rp {{ number_format($project->budget, 0, ',', '.') }}
                    </p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <span class="small text-muted">{{ $project->bids->count() }} penawaran masuk</span>
                    <div class="d-flex gap-1">
                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Detail & Bid</a>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Hapus proyek ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">Belum ada proyek yang dipublikasikan.</div>
        </div>
    @endforelse
</div>
@endsection
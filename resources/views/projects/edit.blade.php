@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Edit Proyek: {{ $project->title }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Judul Proyek</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $project->title) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi Kebutuhan</label>
                <textarea name="description" rows="4" class="form-control" required>{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Anggaran (Rp)</label>
                    <input type="number" name="budget" class="form-control" value="{{ old('budget', $project->budget) }}" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $project->deadline) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status Proyek</label>
                    <select name="status" class="form-select">
                        @foreach(['open', 'in_progress', 'completed', 'closed'] as $st)
                            <option value="{{ $st }}" {{ $project->status === $st ? 'selected' : '' }}>
                                {{ strtoupper(str_replace('_', ' ', $st)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
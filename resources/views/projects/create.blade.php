@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Posting Proyek Baru</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pemilik Proyek (Client)</label>
                <select name="user_id" class="form-select" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }} ({{ $client->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Judul Proyek</label>
                <input type="text" name="title" class="form-control" placeholder="Contoh: Pembuatan Aplikasi Kasir Berbasis Web" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi Kebutuhan</label>
                <textarea name="description" rows="4" class="form-control" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Anggaran / Budget (Rp)</label>
                    <input type="number" name="budget" class="form-control" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Batas Waktu (Deadline)</label>
                    <input type="date" name="deadline" class="form-control">
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Publikasikan Proyek</button>
                <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
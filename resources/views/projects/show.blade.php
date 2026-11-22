@extends('layouts.app')

@section('content')
<a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Kembali ke Daftar Proyek</a>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3 class="mb-0">{{ $project->title }}</h3>

            <div>
                <span class="badge bg-warning text-dark me-1">
                    ★ {{ $project->ratings->count() ? number_format($project->ratings->avg('score'), 1) : 'Belum ada' }} / 5
                </span>
                <span class="badge bg-info text-dark text-uppercase">{{ str_replace('_', ' ', $project->status) }}</span>
            </div>
        </div>
        <p class="text-muted">
            Diposting oleh: <strong>{{ $project->user->name }}</strong> |
            Anggaran: <strong class="text-success">Rp {{ number_format($project->budget, 0, ',', '.') }}</strong> |
            Deadline: {{ $project->deadline ?? '-' }}
        </p>
        <hr>
        <p class="mb-0">{{ $project->description }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-7 mb-4">
        <h5>Daftar Penawaran Masuk ({{ $project->bids->count() }})</h5>
        @forelse($project->bids as $bid)
            <div class="card mb-2 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $bid->user->name }}</strong>
                        <span class="badge bg-{{ $bid->status === 'accepted' ? 'success' : ($bid->status === 'rejected' ? 'danger' : 'secondary') }}">
                            {{ strtoupper($bid->status) }}
                        </span>
                    </div>
                    <div class="text-primary fw-bold my-1">Tawaran: Rp {{ number_format($bid->amount, 0, ',', '.') }}</div>
                    <p class="small mb-2">{{ $bid->proposal }}</p>
                    <div class="d-flex gap-2">
                        @if($bid->status === 'pending')
                            <form action="{{ route('bids.accept', $bid) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Terima Penawaran</button>
                            </form>
                        @endif
                        <form action="{{ route('bids.destroy', $bid) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-light border">Belum ada mahasiswa/freelancer yang mengajukan penawaran.</div>
        @endforelse

        <hr class="my-4">
        <h5>Rating & Ulasan Proyek ({{ $project->ratings->count() }})</h5>
        @forelse($project->ratings as $rating)
            <div class="card mb-2 shadow-sm">
                <div class="card-body py-2">
                    <div class="d-flex justify-content-between">
                        <strong>{{ $rating->user->name }}</strong>
                        <span class="text-warning fw-bold">{{ str_repeat('★', $rating->score) }}{{ str_repeat('☆', 5 - $rating->score) }} ({{ $rating->score }}/5)</span>
                    </div>
                    @if($rating->review)
                        <p class="small text-muted mb-0 mt-1">{{ $rating->review }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-light border">Belum ada rating untuk proyek ini.</div>
        @endforelse
    </div>

    <div class="col-md-5">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Ajukan Penawaran (Bid)</div>
            <div class="card-body">
                <form action="{{ route('bids.store', $project) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pengaju Penawaran</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nominal Penawaran (Rp)</label>
                        <input type="number" name="amount" class="form-control" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Proposal Singkat</label>
                        <textarea name="proposal" rows="3" class="form-control" placeholder="Jelaskan keahlian dan estimasi pengerjaan..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Kirim Penawaran</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Beri Rating Proyek</div>
            <div class="card-body">
                <form action="{{ route('ratings.store', $project) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Skor Rating</label>
                        <select name="score" class="form-select" required>
                            <option value="5">★★★★★ (5 - Sangat Baik)</option>
                            <option value="4">★★★★☆ (4 - Baik)</option>
                            <option value="3">★★★☆☆ (3 - Cukup)</option>
                            <option value="2">★★☆☆☆ (2 - Kurang)</option>
                            <option value="1">★☆☆☆☆ (1 - Sangat Kurang)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ulasan Singkat</label>
                        <textarea name="review" rows="2" class="form-control" placeholder="Tulis pengalaman kerja sama proyek ini..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Kirim Rating</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
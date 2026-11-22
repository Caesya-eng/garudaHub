@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Registrasi Akun Baru</div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Peran (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="freelancer">Freelancer (Mahasiswa)</option>
                            <option value="client">Client (Pemilik Proyek)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (Minimal 6 karakter)</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>
                <hr>
                <p class="small mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <h2 class="fw-bold text-primary">Ganti Password</h2>
                        <p class="text-muted">Amankan akun Anda dengan mengganti password secara berkala.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('profile.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-bold small">Password Sekarang</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4 opacity-25">

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold small">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-bold small">Konfirmasi Password
                                    Baru</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2 fw-bold shadow-sm">Perbarui
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ auth()->user()->role === 'bendahara' ? route('bendahara.dashboard') : route('anggota.dashboard') }}"
                        class="text-muted small text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
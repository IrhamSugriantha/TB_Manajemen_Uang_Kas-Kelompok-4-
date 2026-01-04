@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Tambah Mahasiswa Baru</h2>
                <p class="text-muted">Lengkapi data di bawah ini untuk menambahkan mahasiswa baru.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('bendahara.mahasiswa.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nim" class="form-label fw-bold small">Nomor Induk Mahasiswa (NIM)</label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                                        name="nim" value="{{ old('nim') }}" placeholder="Contoh: 2306000" required>
                                    @error('nim')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nama_lengkap" class="form-label fw-bold small">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                        placeholder="Nama lengkap mahasiswa" required>
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-bold small">Email (Untuk Login)</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{ old('email') }}" placeholder="email@mahasiswa.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_kelamin" class="form-label fw-bold small">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="no_telepon" class="form-label fw-bold small">No. Telepon / WhatsApp</label>
                                <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                    id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}"
                                    placeholder="08xxxxxxxxxx">
                                @error('no_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="alamat" class="form-label fw-bold small">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                    name="alamat" rows="3"
                                    placeholder="Alamat lengkap mahasiswa">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bendahara.mahasiswa.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body py-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i> Informasi Akun
                        </h5>
                        <p class="small text-muted mb-0">Sistem akan secara otomatis membuatkan akun login untuk mahasiswa
                            ini dengan ketentuan:</p>
                        <ul class="small text-muted mt-2">
                            <li><strong>Username:</strong> Alamat email yang didaftarkan.</li>
                            <li><strong>Password Default:</strong> NIM mahasiswa yang bersangkutan.</li>
                            <li>Mahasiswa disarankan segera mengganti password saat pertama kali login.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
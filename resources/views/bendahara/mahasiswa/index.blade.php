@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary">Data Mahasiswa</h2>
                    <p class="text-muted">Kelola data anggota kelas dan status akun mereka.</p>
                </div>
                <a href="{{ route('bendahara.mahasiswa.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-person-plus-fill me-1"></i> Tambah Mahasiswa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3">NIM</th>
                                <th class="border-0 py-3">Nama Lengkap</th>
                                <th class="border-0 py-3">L/P</th>
                                <th class="border-0 py-3">Email</th>
                                <th class="border-0 py-3 text-center">Status</th>
                                <th class="border-0 py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $mhs)
                                <tr>
                                    <td class="px-4 fw-bold">{{ $mhs->nim }}</td>
                                    <td>{{ $mhs->nama_lengkap }}</td>
                                    <td>{{ $mhs->jenis_kelamin }}</td>
                                    <td class="text-muted small">{{ $mhs->user->email }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $mhs->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $mhs->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-end px-4">
                                        <div class="btn-group shadow-sm">
                                            <a href="{{ route('bendahara.mahasiswa.edit', $mhs->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit Data">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('bendahara.mahasiswa.destroy', $mhs->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $mhs->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                    title="{{ $mhs->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    onclick="return confirm('Apakah Anda yakin ingin {{ $mhs->is_active ? 'menonaktifkan' : 'mengaktifkan' }} mahasiswa ini?')">
                                                    <i class="bi {{ $mhs->is_active ? 'bi-person-x' : 'bi-person-check' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
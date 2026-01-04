@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary">Data Pengeluaran Kas</h2>
                    <p class="text-muted">Kelola dan pantau semua pengeluaran kas kelas.</p>
                </div>
                <a href="{{ route('bendahara.pengeluaran.create') }}" class="btn btn-danger shadow-sm">
                    <i class="bi bi-dash-circle-fill me-1"></i> Catat Pengeluaran Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3">Tanggal</th>
                                <th class="border-0 py-3">Kategori</th>
                                <th class="border-0 py-3">Keterangan</th>
                                <th class="border-0 py-3">Jumlah</th>
                                <th class="border-0 py-3 text-center">Bukti</th>
                                <th class="border-0 py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluaran as $item)
                                <tr>
                                    <td class="px-4 fw-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->kategori }}</span></td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td class="text-danger fw-bold text-nowrap">Rp
                                        {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($item->bukti_path)
                                            <a href="{{ asset('storage/' . $item->bukti_path) }}" target="_blank"
                                                class="btn btn-sm btn-light border">
                                                <i class="bi bi-image text-primary"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted small">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="text-end px-4">
                                        <form action="{{ route('bendahara.pengeluaran.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus data pengeluaran ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada data pengeluaran kas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
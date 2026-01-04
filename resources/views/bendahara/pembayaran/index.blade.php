@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary">Riwayat Pembayaran Kas</h2>
                    <p class="text-muted">Pantau semua setoran kas yang telah dicatat.</p>
                </div>
                <a href="{{ route('bendahara.pembayaran.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle-fill me-1"></i> Input Pembayaran Baru
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
                                <th class="border-0 py-3">Mahasiswa</th>
                                <th class="border-0 py-3">Periode</th>
                                <th class="border-0 py-3">Jumlah</th>
                                <th class="border-0 py-3">Pencatat</th>
                                <th class="border-0 py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayaran as $bayar)
                                <tr>
                                    <td class="px-4 text-muted small">
                                        {{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</td>
                                    <td class="fw-bold">{{ $bayar->mahasiswa->nama_lengkap }} <br> <span
                                            class="small text-muted fw-normal">{{ $bayar->mahasiswa->nim }}</span></td>
                                    <td>{{ $bayar->kasBulanan->bulan }} {{ $bayar->kasBulanan->tahun }}</td>
                                    <td class="text-success fw-bold">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="small text-muted">{{ $bayar->recordedBy->name }}</td>
                                    <td class="text-end px-4">
                                        <form action="{{ route('bendahara.pembayaran.destroy', $bayar->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus data pembayaran ini? Transaksi kas juga akan ikut terhapus.')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">Belum ada data pembayaran kas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary text-center">Transparansi Kas Kelas</h2>
                <p class="text-muted text-center">Menjunjung tinggi kejujuran dan transparansi dalam pengelolaan dana kelas.
                </p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body text-center py-4">
                        <h6 class="text-uppercase small opacity-75">Total Dana Masuk</h6>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body text-center py-4">
                        <h6 class="text-uppercase small opacity-75">Total Pengeluaran</h6>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body text-center py-4">
                        <h6 class="text-uppercase small opacity-75">Saldo Kas Saat Ini</h6>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Timeline -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Semua Riwayat Transaksi</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3">Tanggal</th>
                                <th class="border-0 py-3">Deskripsi Transaksi</th>
                                <th class="border-0 py-3 text-end px-4">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $t)
                                <tr>
                                    <td class="px-4 text-muted small">{{ \Carbon\Carbon::parse($t->tanggal)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <div class="fw-bold {{ $t->jenis === 'masuk' ? 'text-dark' : 'text-danger' }}">
                                            @if($t->jenis === 'masuk')
                                                <i class="bi bi-arrow-down-left-circle-fill text-success me-1"></i>
                                            @else
                                                <i class="bi bi-arrow-up-right-circle-fill text-danger me-1"></i>
                                            @endif
                                            {{ $t->keterangan }}
                                        </div>
                                    </td>
                                    <td
                                        class="text-end px-4 fw-bold {{ $t->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                                        {{ $t->jenis === 'masuk' ? '+' : '-' }} Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">Belum ada transaksi yang tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($transaksi->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $transaksi->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
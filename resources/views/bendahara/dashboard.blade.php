@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Dashboard Bendahara</h2>
                <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase opacity-75 small">Total Saldo Kas</h6>
                        <h3 class="fw-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        <div class="mt-2 small">
                            <i class="bi bi-wallet2"></i> Saldo saat ini
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase opacity-75 small">Total Mahasiswa</h6>
                        <h3 class="fw-bold">{{ $totalMahasiswa }} Mahasiswa</h3>
                        <div class="mt-2 small">
                            <i class="bi bi-people"></i> Aktif di sistem
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a href="{{ $kasTerakhir ? route('bendahara.kas-bulanan.show', $kasTerakhir->id) : '#' }}"
                    class="text-decoration-none">
                    <div class="card border-0 shadow-sm bg-info text-white">
                        <div class="card-body">
                            <h6 class="card-title text-uppercase opacity-75 small">Lunas
                                ({{ $kasTerakhir ? $kasTerakhir->bulan : 'Periode Ini' }})</h6>
                            <h3 class="fw-bold">{{ $jumlahLunas }} Mahasiswa</h3>
                            <div class="mt-2 small">
                                <i class="bi bi-check-circle"></i> Sudah bayar kas
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ $kasTerakhir ? route('bendahara.kas-bulanan.show', $kasTerakhir->id) : '#' }}"
                    class="text-decoration-none">
                    <div class="card border-0 shadow-sm bg-danger text-white">
                        <div class="card-body">
                            <h6 class="card-title text-uppercase opacity-75 small">Menunggak / Belum Lunas</h6>
                            <h3 class="fw-bold">{{ $jumlahMenunggak }} Mahasiswa</h3>
                            <div class="mt-2 small">
                                <i class="bi bi-exclamation-triangle"></i> Cek detail penunggak
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <!-- Recent Transactions -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Transaksi Terakhir</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4">Tanggal</th>
                                        <th class="border-0">Keterangan</th>
                                        <th class="border-0">Jenis</th>
                                        <th class="border-0 text-end px-4">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($transaksiTerakhir as $trx)
                                        <tr>
                                            <td class="px-4 text-muted">{{ $trx->tanggal->format('d/m/Y') }}</td>
                                            <td>{{ $trx->keterangan }}</td>
                                            <td>
                                                <span class="badge {{ $trx->jenis === 'masuk' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($trx->jenis) }}
                                                </span>
                                            </td>
                                            <td
                                                class="text-end px-4 fw-bold {{ $trx->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                                                {{ $trx->jenis === 'masuk' ? '+' : '-' }} Rp
                                                {{ number_format($trx->jumlah, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada transaksi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('bendahara.pembayaran.create') }}" class="btn btn-primary py-2 shadow-sm">
                                <i class="bi bi-plus-circle me-1"></i> Input Pembayaran Kas
                            </a>
                            <a href="{{ route('bendahara.pengeluaran.create') }}" class="btn btn-outline-danger py-2">
                                <i class="bi bi-dash-circle me-1"></i> Catat Pengeluaran
                            </a>
                            <hr>
                            <a href="{{ route('bendahara.mahasiswa.create') }}" class="btn btn-light py-2 text-start">
                                <i class="bi bi-person-plus me-2 text-success"></i> Tambah Mahasiswa
                            </a>
                            <a href="{{ route('bendahara.kas-bulanan.create') }}" class="btn btn-light py-2 text-start">
                                <i class="bi bi-calendar-plus me-2 text-info"></i> Atur Kas Bulanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
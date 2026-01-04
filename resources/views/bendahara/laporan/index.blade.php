@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary">Laporan Kas Kelas</h2>
                    <p class="text-muted">Analisis pemasukan dan pengeluaran secara menyeluruh.</p>
                </div>
                <form action="{{ route('bendahara.laporan.pdf') }}" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    <button type="submit" class="btn btn-outline-danger shadow-sm">
                        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Cetak PDF
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('bendahara.laporan.index') }}" method="GET" class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-filter me-1"></i> Filter Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success text-white">
                    <div class="card-body py-3">
                        <h6 class="text-uppercase small opacity-75">Total Pemasukan</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-danger text-white">
                    <div class="card-body py-3">
                        <h6 class="text-uppercase small opacity-75">Total Pengeluaran</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body py-3">
                        <h6 class="text-uppercase small opacity-75">Saldo Akhir</h6>
                        <h4 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Rincian Transaksi</h5>
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
                            @forelse($transaksi as $trx)
                                <tr>
                                    <td class="px-4 text-muted">{{ \Carbon\Carbon::parse($trx->tanggal)->format('d/m/Y') }}</td>
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
                                    <td colspan="4" class="text-center py-5 text-muted">Tidak ada transaksi ditemukan pada
                                        periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
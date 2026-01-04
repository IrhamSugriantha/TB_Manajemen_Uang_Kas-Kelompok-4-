@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Dashboard Anggota</h2>
                <p class="text-muted">Halo {{ auth()->user()->name }}, selamat datang di pusat informasi kas kelas.</p>
            </div>
        </div>

        <div class="row mb-4">
            <!-- Personal Status Card -->
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm {{ $isLunasBulanIni ? 'bg-success' : 'bg-warning' }} text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <h6 class="text-uppercase small opacity-75">Status Kas Bulan ini
                            ({{ $kasTerakhir ? $kasTerakhir->bulan : '...' }})</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i
                                class="bi {{ $isLunasBulanIni ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' }} display-5 me-3"></i>
                            <div>
                                <h3 class="fw-bold mb-0">{{ $isLunasBulanIni ? 'Sudah Lunas' : 'Belum Lunas' }}</h3>
                                <p class="mb-0 opacity-75 small">
                                    @if($isLunasBulanIni)
                                        Terima kasih telah berkontribusi tepat waktu!
                                    @else
                                        Segera lakukan pembayaran ke Bendahara.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Class Cash Transparency Card -->
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-primary text-white h-100">
                    <div class="card-body d-flex flex-column justify-content-center py-4">
                        <h6 class="text-uppercase small opacity-75">Total Saldo Kas Kelas</h6>
                        <div class="d-flex align-items-center mt-2">
                            <i class="bi bi-wallet2 display-5 me-3"></i>
                            <div>
                                <h3 class="fw-bold mb-0">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                                <p class="mb-0 opacity-75 small text-nowrap">Saldo gabungan seluruh anggota saat ini.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Personal History -->
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Riwayat Pembayaran Terakhir</h5>
                        <a href="{{ route('anggota.riwayat') }}"
                            class="btn btn-sm btn-light border text-primary fw-bold">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4">Tanggal</th>
                                        <th class="border-0">Periode Kas</th>
                                        <th class="border-0 text-end px-4">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayatPribadi as $rp)
                                        <tr>
                                            <td class="px-4 text-muted small">
                                                {{ \Carbon\Carbon::parse($rp->tanggal_bayar)->format('d M Y') }}</td>
                                            <td class="fw-bold">{{ $rp->kasBulanan->bulan }} {{ $rp->kasBulanan->tahun }}</td>
                                            <td class="text-end px-4 text-success fw-bold">Rp
                                                {{ number_format($rp->jumlah_bayar, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted small">Belum ada riwayat
                                                pembayaran.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body py-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-grid-fill text-primary me-2"></i> Akses Menu</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('anggota.status-kas') }}"
                                class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center">
                                <i class="bi bi-calendar-check me-3 text-success fs-5"></i>
                                <div>
                                    <div class="fw-bold">Cek Kewajiban Kas</div>
                                    <div class="small text-muted">Lihat bulan apa saja yang belum lunas.</div>
                                </div>
                            </a>
                            <a href="{{ route('anggota.transparansi') }}"
                                class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center">
                                <i class="bi bi-search me-3 text-info fs-5"></i>
                                <div>
                                    <div class="fw-bold">Transparansi Keuangan</div>
                                    <div class="small text-muted">Pantau penggunaan uang kas kelas.</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
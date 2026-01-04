@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Status Kewajiban Kas</h2>
                <p class="text-muted">Pantau status pembayaran kas Anda untuk setiap periode yang telah ditentukan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 px-4 py-3">Bulan / Tahun</th>
                                        <th class="border-0 py-3">Nominal Wajib</th>
                                        <th class="border-0 py-3 text-center">Status</th>
                                        <th class="border-0 py-3 text-end px-4">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pembayaranStatus as $item)
                                        <tr>
                                            <td class="px-4 fw-bold">{{ $item['kas']->bulan }} {{ $item['kas']->tahun }}</td>
                                            <td>Rp {{ number_format($item['kas']->nominal, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if($item['status'] == 'Lunas')
                                                    <span class="badge bg-success shadow-sm">
                                                        <i class="bi bi-check-circle me-1"></i> LUNAS
                                                    </span>
                                                @elseif($item['status'] == 'Belum Lunas')
                                                    <span class="badge bg-warning text-dark shadow-sm">
                                                        <i class="bi bi-hourglass-split me-1"></i> BELUM LUNAS
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger shadow-sm">
                                                        <i class="bi bi-x-circle me-1"></i> MENUNGGAK
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end px-4">
                                                <span class="text-muted small">
                                                    @if($item['status'] == 'Lunas')
                                                        Terima kasih, sudah lunas!
                                                    @else
                                                        Sisa: <strong class="text-danger">Rp
                                                            {{ number_format($item['sisa'], 0, ',', '.') }}</strong>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">Belum ada periode kas yang
                                                ditentukan oleh Bendahara.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body py-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i> Tentang Kewajiban
                            Kas</h5>
                        <p class="small text-muted mb-0">Sebagai anggota kelas yang baik, pembayaraan kas rutin sangat
                            membantu program kerja kelas berjalan lancar.</p>
                        <hr>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success me-2">Lunas</span>
                            <span class="small text-muted">Kewajiban sudah dibayar penuh.</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-warning text-dark me-2">Belum Lunas</span>
                            <span class="small text-muted">Sudah dicicil tapi belum penuh.</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2">Menunggak</span>
                            <span class="small text-muted">Belum ada pembayaran sama sekali.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
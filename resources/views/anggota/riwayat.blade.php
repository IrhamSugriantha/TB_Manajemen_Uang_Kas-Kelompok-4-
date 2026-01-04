@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Riwayat Pembayaran Saya</h2>
                <p class="text-muted">Berikut adalah daftar setoran kas yang telah Anda lakukan.</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3">Tanggal Bayar</th>
                                <th class="border-0 py-3">Periode Kas</th>
                                <th class="border-0 py-3">Jumlah Bayar</th>
                                <th class="border-0 py-3">Diterima Oleh</th>
                                <th class="border-0 py-3">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $r)
                                <tr>
                                    <td class="px-4 text-muted fw-bold">
                                        {{ \Carbon\Carbon::parse($r->tanggal_bayar)->format('d F Y') }}</td>
                                    <td class="fw-bold text-primary">{{ $r->kasBulanan->bulan }} {{ $r->kasBulanan->tahun }}
                                    </td>
                                    <td class="fw-bold">Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}</td>
                                    <td class="small">{{ $r->recordedBy->name }}</td>
                                    <td class="text-muted italic small">{{ $r->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Anda belum memiliki riwayat pembayaran
                                        kas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
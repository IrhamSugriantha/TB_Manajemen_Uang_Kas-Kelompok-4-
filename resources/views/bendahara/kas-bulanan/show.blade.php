@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold text-primary">Detail Pembayaran: {{ $kasBulanan->bulan }} {{ $kasBulanan->tahun }}
                    </h2>
                    <p class="text-muted">Nominal Wajib: <strong>Rp
                            {{ number_format($kasBulanan->nominal, 0, ',', '.') }}</strong></p>
                </div>
                <a href="{{ route('bendahara.kas-bulanan.index') }}" class="btn btn-light border shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3">Nama Mahasiswa</th>
                                <th class="border-0 py-3">NIM</th>
                                <th class="border-0 py-3">Total Bayar</th>
                                <th class="border-0 py-3">Sisa Kekurangan</th>
                                <th class="border-0 py-3 text-center px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataReport as $data)
                                <tr>
                                    <td class="px-4 fw-bold">{{ $data['nama'] }}</td>
                                    <td class="text-muted">{{ $data['nim'] }}</td>
                                    <td>Rp {{ number_format($data['total_bayar'], 0, ',', '.') }}</td>
                                    <td class="{{ $data['sisa'] > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($data['sisa'], 0, ',', '.') }}
                                    </td>
                                    <td class="text-center px-4">
                                        @if($data['status'] == 'Lunas')
                                            <span class="badge bg-success">LUNAS</span>
                                        @elseif($data['status'] == 'Belum Lunas')
                                            <span class="badge bg-warning text-dark">BELUM LUNAS</span>
                                        @else
                                            <span class="badge bg-danger">MENUNGGAK</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
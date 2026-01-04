@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-primary">Pengaturan Kas Bulanan</h2>
                <p class="text-muted">Tentukan nominal uang kas wajib per periode bulan.</p>
            </div>
            <a href="{{ route('bendahara.kas-bulanan.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-calendar-plus me-1"></i> Tambah Periode Kas
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">Bulan / Tahun</th>
                            <th class="border-0 py-3">Nominal Wajib</th>
                            <th class="border-0 py-3">Keterangan</th>
                            <th class="border-0 py-3">Dibuat Oleh</th>
                            <th class="border-0 py-3 text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kasBulanan as $kas)
                        <tr>
                            <td class="px-4 fw-bold">{{ $kas->bulan }} {{ $kas->tahun }}</td>
                            <td class="text-primary fw-bold">Rp {{ number_format($kas->nominal, 0, ',', '.') }}</td>
                            <td>{{ $kas->keterangan ?? '-' }}</td>
                            <td class="small text-muted">{{ $kas->createdBy->name }}</td>
                            <td class="text-end px-4">
                                <a href="{{ route('bendahara.kas-bulanan.show', $kas->id) }}" class="btn btn-sm btn-outline-info me-1" title="Lihat Status Pembayaran">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <form action="{{ route('bendahara.kas-bulanan.destroy', $kas->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus periode ini?')"
                                            {{ $kas->pembayaranKass()->count() > 0 ? 'disabled' : '' }}
                                            title="{{ $kas->pembayaranKass()->count() > 0 ? 'Sudah ada pembayaran' : 'Hapus' }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pengaturan kas bulanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

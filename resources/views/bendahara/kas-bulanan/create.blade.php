@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Tambah Periode Kas Bulanan</h2>
                <p class="text-muted">Tentukan nominal kas kelas untuk bulan dan tahun tertentu.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('bendahara.kas-bulanan.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="bulan" class="form-label fw-bold small">Pilih Bulan</label>
                                <select class="form-select @error('bulan') is-invalid @enderror" id="bulan" name="bulan"
                                    required>
                                    <option value="" selected disabled>Pilih Bulan</option>
                                    @foreach($bulanList as $bulan)
                                        <option value="{{ $bulan }}" {{ old('bulan') == $bulan ? 'selected' : '' }}>{{ $bulan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bulan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tahun" class="form-label fw-bold small">Tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun"
                                    name="tahun" value="{{ old('tahun', date('Y')) }}" min="2020" required>
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nominal" class="form-label fw-bold small">Nominal Kas (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">Rp</span>
                                    <input type="number"
                                        class="form-control @error('nominal') is-invalid @enderror border-start-0"
                                        id="nominal" name="nominal" value="{{ old('nominal', 10000) }}"
                                        placeholder="Contoh: 10000" min="0" required>
                                </div>
                                @error('nominal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-bold small">Keterangan (Opsional)</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    name="keterangan" rows="2"
                                    placeholder="Contoh: Pembayaran kas rutin">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bendahara.kas-bulanan.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Periode</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-lightbulb-fill me-2"></i> Penting
                            Mendefinisikan Periode</h5>
                        <p class="small text-muted mb-3">Sistem menggunakan periode ini untuk menentukan kewajiban
                            pembayaran setiap mahasiswa:</p>
                        <ul class="small text-muted">
                            <li>Mahasiswa dianggap "Lunas" jika sudah membayar pada periode tertentu.</li>
                            <li>Status "Menunggak" dihitung jika periode sudah ada tetapi belum ada pembayaran dicatat.</li>
                            <li>Anda dapat menentukan nominal yang berbeda untuk setiap bulan jika diperlukan (misal: bulan
                                acara khusus).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
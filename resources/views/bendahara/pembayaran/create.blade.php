@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Input Pembayaran Kas</h2>
                <p class="text-muted">Catat setoran uang kas mahasiswa secara real-time.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('bendahara.pembayaran.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="mahasiswa_id" class="form-label fw-bold small">Pilih Mahasiswa</label>
                                <select class="form-select @error('mahasiswa_id') is-invalid @enderror" id="mahasiswa_id"
                                    name="mahasiswa_id" required>
                                    <option value="" selected disabled>Pilih Nama Mahasiswa</option>
                                    @foreach($mahasiswas as $mhs)
                                        <option value="{{ $mhs->id }}" {{ old('mahasiswa_id') == $mhs->id ? 'selected' : '' }}>
                                            {{ $mhs->nim }} - {{ $mhs->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @error('mahasiswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kas_bulanan_id" class="form-label fw-bold small">Pilih Periode Kas</label>
                                <select class="form-select @error('kas_bulanan_id') is-invalid @enderror"
                                    id="kas_bulanan_id" name="kas_bulanan_id" required>
                                    <option value="" selected disabled>Pilih Bulan & Tahun</option>
                                    @foreach($kasBulanan as $kas)
                                        <option value="{{ $kas->id }}" data-nominal="{{ $kas->nominal }}" {{ old('kas_bulanan_id') == $kas->id ? 'selected' : '' }}>
                                            {{ $kas->bulan }} {{ $kas->tahun }} (Rp
                                            {{ number_format($kas->nominal, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('kas_bulanan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_bayar" class="form-label fw-bold small">Tanggal Bayar</label>
                                    <input type="date" class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                        id="tanggal_bayar" name="tanggal_bayar"
                                        value="{{ old('tanggal_bayar', date('Y-m-d')) }}" required>
                                    @error('tanggal_bayar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah_bayar" class="form-label fw-bold small">Jumlah Bayar (Rp)</label>
                                    <input type="number" class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                        id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar') }}" required>
                                    @error('jumlah_bayar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label fw-bold small">Keterangan Tambahan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    name="keterangan" rows="2"
                                    placeholder="Contoh: Lunas via transfer">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bendahara.pembayaran.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">Catat Pembayaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm bg-primary text-white mb-4">
                    <div class="card-body">
                        <h5 class="fw-bold"><i class="bi bi-lightning-fill me-1 text-warning"></i> Auto-fill Nominal</h5>
                        <p class="small mb-0 opacity-75">Gunakan tombol di bawah ini untuk mengisi jumlah bayar sesuai
                            nominal periode yang dipilih.</p>
                        <button type="button" class="btn btn-light btn-sm mt-3 fw-bold" onclick="fillNominal()">Gunakan
                            Nominal Wajib</button>
                    </div>
                </div>
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 small text-muted text-uppercase">Tips Penginputan</h5>
                        <ul class="small text-muted ps-3">
                            <li class="mb-2">Satu input pembayaran merepresentasikan pelunasan untuk satu periode bulan.
                            </li>
                            <li class="mb-2">Data ini akan otomatis tercatat sebagai <strong>Pemasukan Kas</strong> di
                                laporan transparansi.</li>
                            <li>Pastikan mahasiswa yang dipilih benar sesuai dengan NIM-nya.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillNominal() {
            const select = document.getElementById('kas_bulanan_id');
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption.value) {
                const nominal = selectedOption.getAttribute('data-nominal');
                document.getElementById('jumlah_bayar').value = nominal;
            } else {
                alert('Silakan pilih periode kas terlebih dahulu!');
            }
        }
    </script>
@endsection
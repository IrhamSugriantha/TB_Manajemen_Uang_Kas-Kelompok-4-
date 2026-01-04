@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2 class="fw-bold text-primary">Catat Pengeluaran Baru</h2>
                <p class="text-muted">Gunakan dana kas kelas untuk keperluan yang transparan.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('bendahara.pengeluaran.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="tanggal" class="form-label fw-bold small">Tanggal Pengeluaran</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                                    name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="kategori" class="form-label fw-bold small">Kategori</label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                        name="kategori" required>
                                        <option value="" selected disabled>Pilih Kategori</option>
                                        <option value="Konsumsi" {{ old('kategori') == 'Konsumsi' ? 'selected' : '' }}>
                                            Konsumsi</option>
                                        <option value="Perlengkapan" {{ old('kategori') == 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                                        <option value="Foto Copy / Print" {{ old('kategori') == 'Foto Copy / Print' ? 'selected' : '' }}>Foto Copy / Print</option>
                                        <option value="Sosial / Duka" {{ old('kategori') == 'Sosial / Duka' ? 'selected' : '' }}>Sosial / Duka</option>
                                        <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label fw-bold small">Jumlah Pengeluaran (Rp)</label>
                                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                        id="jumlah" name="jumlah" value="{{ old('jumlah') }}" placeholder="Contoh: 50000"
                                        min="0" required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label fw-bold small">Keterangan / Deskripsi</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan"
                                    name="keterangan" rows="3" placeholder="Contoh: Beli snack untuk rapat kelas"
                                    required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="bukti" class="form-label fw-bold small">Upload Bukti / Nota (Opsional)</label>
                                <input type="file" class="form-control @error('bukti') is-invalid @enderror" id="bukti"
                                    name="bukti" accept="image/*">
                                <div class="form-text small">Format: JPEG, PNG, JPG (Maks. 2MB)</div>
                                @error('bukti')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('bendahara.pengeluaran.index') }}" class="btn btn-light px-4">Batal</a>
                                <button type="submit" class="btn btn-danger px-4 shadow-sm">Simpan Pengeluaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow-sm bg-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-danger"><i class="bi bi-shield-lock-fill me-2"></i> Aturan Transparansi
                        </h5>
                        <p class="small text-muted mb-3">Setiap pengeluaran kas harus dapat dipertanggungjawabkan:</p>
                        <ul class="small text-muted ps-3">
                            <li class="mb-2">Pastikan kategori sesuai dengan jenis pengeluaran.</li>
                            <li class="mb-2">Sangat disarankan untuk melampirkan foto nota/struk belanja sebagai bukti sah
                                kepada anggota kelas.</li>
                            <li class="mb-2">Data pengeluaran akan langsung mengurangi total saldo kas kelas di dashboard
                                anggota.</li>
                            <li>Gunakan kolom keterangan sejelas mungkin agar tidak menimbulkan kecurigaan.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
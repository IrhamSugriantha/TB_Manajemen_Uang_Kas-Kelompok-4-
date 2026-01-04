<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasBulananController extends Controller
{
    public function index()
    {
        $kasBulanan = \App\Models\KasBulanan::with('createdBy')->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('bendahara.kas-bulanan.index', compact('kasBulanan'));
    }

    public function create()
    {
        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('bendahara.kas-bulanan.create', compact('bulanList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required|numeric|min:2020',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
        ]);

        // Check if already exists
        $exists = \App\Models\KasBulanan::where('bulan', $request->bulan)->where('tahun', $request->tahun)->exists();
        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['bulan' => 'Periode kas untuk bulan dan tahun ini sudah ada.']);
        }

        \App\Models\KasBulanan::create([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('bendahara.kas-bulanan.index')->with('success', 'Pengaturan kas bulanan berhasil disimpan.');
    }

    public function show(\App\Models\KasBulanan $kasBulanan)
    {
        $mahasiswas = \App\Models\Mahasiswa::where('is_active', true)->get();

        $dataReport = $mahasiswas->map(function ($mhs) use ($kasBulanan) {
            $totalBayar = \App\Models\PembayaranKas::where('mahasiswa_id', $mhs->id)
                ->where('kas_bulanan_id', $kasBulanan->id)
                ->sum('jumlah_bayar');

            $status = 'Menunggak';
            if ($totalBayar >= $kasBulanan->nominal) {
                $status = 'Lunas';
            } elseif ($totalBayar > 0) {
                $status = 'Belum Lunas';
            }

            return [
                'nama' => $mhs->nama_lengkap,
                'nim' => $mhs->nim,
                'total_bayar' => $totalBayar,
                'status' => $status,
                'sisa' => max(0, $kasBulanan->nominal - $totalBayar),
            ];
        });

        return view('bendahara.kas-bulanan.show', compact('kasBulanan', 'dataReport'));
    }

    public function destroy(\App\Models\KasBulanan $kasBulanan)
    {
        // Check if there are payments
        if ($kasBulanan->pembayaranKass()->exists()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus periode kas yang sudah memiliki data pembayaran.');
        }

        $kasBulanan->delete();
        return redirect()->route('bendahara.kas-bulanan.index')->with('success', 'Periode kas berhasil dihapus.');
    }
}

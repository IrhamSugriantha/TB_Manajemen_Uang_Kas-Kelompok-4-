<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        // Saldo Kas Kelas (Transparency)
        $totalMasuk = \App\Models\TransaksiKas::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = \App\Models\TransaksiKas::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        // Personal Status
        $kasTerakhir = \App\Models\KasBulanan::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->first();
        $isLunasBulanIni = false;
        if ($kasTerakhir) {
            $totalBayar = \App\Models\PembayaranKas::where('mahasiswa_id', $mahasiswa->id)
                ->where('kas_bulanan_id', $kasTerakhir->id)
                ->sum('jumlah_bayar');

            $isLunasBulanIni = $totalBayar >= $kasTerakhir->nominal;
        }

        $riwayatPribadi = \App\Models\PembayaranKas::with('kasBulanan')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal_bayar', 'desc')
            ->take(5)
            ->get();

        return view('anggota.dashboard', compact('saldo', 'isLunasBulanIni', 'kasTerakhir', 'riwayatPribadi'));
    }

    public function status()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $kasBulanan = \App\Models\KasBulanan::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        $pembayaranStatus = $kasBulanan->map(function ($kas) use ($mahasiswa) {
            $totalBayar = \App\Models\PembayaranKas::where('mahasiswa_id', $mahasiswa->id)
                ->where('kas_bulanan_id', $kas->id)
                ->sum('jumlah_bayar');

            return [
                'kas' => $kas,
                'total_bayar' => $totalBayar,
                'status' => $totalBayar >= $kas->nominal ? 'Lunas' : ($totalBayar > 0 ? 'Belum Lunas' : 'Menunggak'),
                'sisa' => max(0, $kas->nominal - $totalBayar),
            ];
        });

        return view('anggota.status-kas', compact('pembayaranStatus'));
    }

    public function riwayat()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $riwayat = \App\Models\PembayaranKas::with(['kasBulanan', 'recordedBy'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view('anggota.riwayat', compact('riwayat'));
    }

    public function transparansi()
    {
        $transaksi = \App\Models\TransaksiKas::orderBy('tanggal', 'desc')->paginate(15);

        $totalMasuk = \App\Models\TransaksiKas::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = \App\Models\TransaksiKas::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('anggota.transparansi', compact('transaksi', 'saldo', 'totalMasuk', 'totalKeluar'));
    }
}

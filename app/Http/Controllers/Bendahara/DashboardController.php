<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMahasiswa = \App\Models\Mahasiswa::where('is_active', true)->count();
        $totalMasuk = \App\Models\TransaksiKas::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = \App\Models\TransaksiKas::where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        // Mendapatkan periode kas terakhir
        $kasTerakhir = \App\Models\KasBulanan::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->first();

        $jumlahLunas = 0;
        $jumlahMenunggak = 0;

        if ($kasTerakhir) {
            $mahasiswas = \App\Models\Mahasiswa::where('is_active', true)->get();
            $jumlahLunas = 0;

            foreach ($mahasiswas as $mhs) {
                $totalBayar = \App\Models\PembayaranKas::where('mahasiswa_id', $mhs->id)
                    ->where('kas_bulanan_id', $kasTerakhir->id)
                    ->sum('jumlah_bayar');

                if ($totalBayar >= $kasTerakhir->nominal) {
                    $jumlahLunas++;
                }
            }

            $jumlahMenunggak = $totalMahasiswa - $jumlahLunas;
        }

        $transaksiTerakhir = \App\Models\TransaksiKas::orderBy('created_at', 'desc')->take(5)->get();

        return view('bendahara.dashboard', compact(
            'totalMahasiswa',
            'saldo',
            'jumlahLunas',
            'jumlahMenunggak',
            'transaksiTerakhir',
            'kasTerakhir'
        ));
    }
}

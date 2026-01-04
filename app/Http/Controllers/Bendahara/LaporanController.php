<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\TransaksiKas::orderBy('tanggal', 'desc');

        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        $transaksi = $query->get();
        $totalMasuk = $transaksi->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $transaksi->where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return view('bendahara.laporan.index', compact('transaksi', 'totalMasuk', 'totalKeluar', 'saldo'));
    }

    public function downloadPdf(Request $request)
    {
        $query = \App\Models\TransaksiKas::orderBy('tanggal', 'asc');

        if ($request->filled('start_date')) {
            $query->where('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal', '<=', $request->end_date);
        }

        $transaksi = $query->get();
        $totalMasuk = $transaksi->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $transaksi->where('jenis', 'keluar')->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        $periode = "Semua Periode";
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $periode = $request->start_date . " s/d " . $request->end_date;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('bendahara.laporan.pdf', compact('transaksi', 'totalMasuk', 'totalKeluar', 'saldo', 'periode'));
        return $pdf->download('laporan-kas-' . date('Y-m-d') . '.pdf');
    }
}

<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = \App\Models\PembayaranKas::with(['mahasiswa', 'kasBulanan', 'recordedBy'])
            ->orderBy('tanggal_bayar', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('bendahara.pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $mahasiswas = \App\Models\Mahasiswa::where('is_active', true)->orderBy('nama_lengkap')->get();
        $kasBulanan = \App\Models\KasBulanan::orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
        return view('bendahara.pembayaran.create', compact('mahasiswas', 'kasBulanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'kas_bulanan_id' => 'required|exists:kas_bulanan,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'keterangan' => 'nullable',
        ]);

        // Check total paid for this period
        $kas = \App\Models\KasBulanan::findOrFail($request->kas_bulanan_id);
        $totalPaid = \App\Models\PembayaranKas::where('mahasiswa_id', $request->mahasiswa_id)
            ->where('kas_bulanan_id', $request->kas_bulanan_id)
            ->sum('jumlah_bayar');

        if ($totalPaid >= $kas->nominal) {
            return redirect()->back()->withInput()->withErrors(['kas_bulanan_id' => 'Mahasiswa ini sudah melunasi kas untuk periode tersebut.']);
        }

        // Optional: Check if the new payment exceeds the total nominal (if you want to restrict it)
        // If you want to allow overpayment, skip this check.
        // if (($totalPaid + $request->jumlah_bayar) > $kas->nominal) { ... }

        \DB::transaction(function () use ($request) {
            $pembayaran = \App\Models\PembayaranKas::create([
                'mahasiswa_id' => $request->mahasiswa_id,
                'kas_bulanan_id' => $request->kas_bulanan_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah_bayar' => $request->jumlah_bayar,
                'keterangan' => $request->keterangan,
                'recorded_by' => auth()->id(),
            ]);

            // Recording to transaction log
            $mhs = \App\Models\Mahasiswa::find($request->mahasiswa_id);
            $kas = \App\Models\KasBulanan::find($request->kas_bulanan_id);

            \App\Models\TransaksiKas::create([
                'jenis' => 'masuk',
                'jumlah' => $request->jumlah_bayar,
                'referensi_type' => \App\Models\PembayaranKas::class,
                'referensi_id' => $pembayaran->id,
                'keterangan' => "Pembayaran Kas {$mhs->nama_lengkap} ({$kas->bulan} {$kas->tahun})",
                'tanggal' => $request->tanggal_bayar,
            ]);
        });

        return redirect()->route('bendahara.pembayaran.index')->with('success', 'Pembayaran kas berhasil dicatat.');
    }

    public function destroy(\App\Models\PembayaranKas $pembayaran)
    {
        \DB::transaction(function () use ($pembayaran) {
            // Delete associated transaction
            \App\Models\TransaksiKas::where('referensi_type', \App\Models\PembayaranKas::class)
                ->where('referensi_id', $pembayaran->id)
                ->delete();

            $pembayaran->delete();
        });

        return redirect()->route('bendahara.pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }
}

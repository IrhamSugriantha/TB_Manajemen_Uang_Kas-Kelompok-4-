<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = \App\Models\PengeluaranKas::with('recordedBy')->orderBy('tanggal', 'desc')->get();
        return view('bendahara.pengeluaran.index', compact('pengeluaran'));
    }

    public function create()
    {
        return view('bendahara.pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'kategori' => 'required',
            'keterangan' => 'required',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        \DB::transaction(function () use ($request) {
            $buktiPath = null;
            if ($request->hasFile('bukti')) {
                $buktiPath = $request->file('bukti')->store('bukti_pengeluaran', 'public');
            }

            $pengeluaran = \App\Models\PengeluaranKas::create([
                'tanggal' => $request->tanggal,
                'jumlah' => $request->jumlah,
                'kategori' => $request->kategori,
                'keterangan' => $request->keterangan,
                'bukti_path' => $buktiPath,
                'recorded_by' => auth()->id(),
            ]);

            // Recording to transaction log
            \App\Models\TransaksiKas::create([
                'jenis' => 'keluar',
                'jumlah' => $request->jumlah,
                'referensi_type' => \App\Models\PengeluaranKas::class,
                'referensi_id' => $pengeluaran->id,
                'keterangan' => "Pengeluaran: {$request->kategori} - {$request->keterangan}",
                'tanggal' => $request->tanggal,
            ]);
        });

        return redirect()->route('bendahara.pengeluaran.index')->with('success', 'Pengeluaran kas berhasil dicatat.');
    }

    public function destroy(\App\Models\PengeluaranKas $pengeluaran)
    {
        \DB::transaction(function () use ($pengeluaran) {
            // Delete associated transaction
            \App\Models\TransaksiKas::where('referensi_type', \App\Models\PengeluaranKas::class)
                ->where('referensi_id', $pengeluaran->id)
                ->delete();

            // Delete file if exists
            if ($pengeluaran->bukti_path) {
                \Storage::disk('public')->delete($pengeluaran->bukti_path);
            }

            $pengeluaran->delete();
        });

        return redirect()->route('bendahara.pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}

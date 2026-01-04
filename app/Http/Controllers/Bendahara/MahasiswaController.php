<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = \App\Models\Mahasiswa::with('user')->orderBy('nama_lengkap')->get();
        return view('bendahara.mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('bendahara.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:L,P',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
        ]);

        \DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => \Hash::make($request->nim), // Default password is NIM
                'role' => 'anggota',
                'is_active' => true,
            ]);

            \App\Models\Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'nama_lengkap' => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
                'is_active' => true,
            ]);
        });

        return redirect()->route('bendahara.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan. Password default adalah NIM.');
    }

    public function edit(\App\Models\Mahasiswa $mahasiswa)
    {
        return view('bendahara.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, \App\Models\Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        \DB::transaction(function () use ($request, $mahasiswa) {
            $mahasiswa->update($request->only(['nim', 'nama_lengkap', 'jenis_kelamin', 'no_telepon', 'alamat']));

            $mahasiswa->user->update([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
            ]);
        });

        return redirect()->route('bendahara.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(\App\Models\Mahasiswa $mahasiswa)
    {
        $mahasiswa->update(['is_active' => !$mahasiswa->is_active]);
        $mahasiswa->user->update(['is_active' => $mahasiswa->is_active]);

        $status = $mahasiswa->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Mahasiswa berhasil $status.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        return view('mata-pelajaran.index', ['mataPelajaran' => MataPelajaran::all()]);
    }
    public function create()
    {
        return view('mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        MataPelajaran::create($request->validate([
            'kode' => 'required|unique:mata_pelajaran',
            'nama' => 'required',
            'kelompok' => 'nullable',
            'kkm' => 'nullable|integer',
            'jam_per_minggu' => 'nullable|integer',
            'deskripsi' => 'nullable'
        ]));
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran ditambahkan.');
    }

    public function show(MataPelajaran $mataPelajaran)
    {
        return redirect()->route('mata-pelajaran.index');
    }
    public function edit(MataPelajaran $mataPelajaran)
    {
        return view('mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->update($request->validate([
            'kode' => 'required|unique:mata_pelajaran,kode,' . $mataPelajaran->id,
            'nama' => 'required',
            'kelompok' => 'nullable',
            'kkm' => 'nullable|integer',
            'jam_per_minggu' => 'nullable|integer',
            'deskripsi' => 'nullable'
        ]));
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran diupdate.');
    }

    public function destroy(MataPelajaran $mataPelajaran)
    {
        $mataPelajaran->delete();
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata pelajaran dihapus.');
    }
}

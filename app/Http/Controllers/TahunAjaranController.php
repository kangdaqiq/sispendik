<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $ta = TahunAjaran::latest()->paginate(10);
        return view('tahun-ajaran.index', compact('ta'));
    }

    public function create()
    {
        return view('tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_aktif' => 'boolean',
        ]);
        // Jika diset aktif, nonaktifkan yang lain
        if (!empty($validated['is_aktif'])) {
            TahunAjaran::where('is_aktif', true)->update(['is_aktif' => false]);
        }
        TahunAjaran::create($validated);
        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_aktif' => 'boolean',
        ]);
        if (!empty($validated['is_aktif'])) {
            TahunAjaran::where('is_aktif', true)->where('id', '!=', $tahunAjaran->id)->update(['is_aktif' => false]);
        }
        $tahunAjaran->update($validated);
        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil diupdate.');
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    public function show(TahunAjaran $tahunAjaran)
    {
        return redirect()->route('tahun-ajaran.index');
    }
}

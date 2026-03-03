<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();
        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%")->orWhere('nip', 'like', "%{$request->search}%");
        }
        $guru = $query->latest()->paginate(15)->withQueryString();
        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'nullable|unique:guru',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'alamat' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
            'pendidikan_terakhir' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('foto'))
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        Guru::create($validated);
        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }
    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nip' => 'nullable|unique:guru,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'nullable|email',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        if ($request->hasFile('foto'))
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        $guru->update($validated + $request->only(['tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'rt', 'rw', 'kode_pos', 'no_telp', 'pendidikan_terakhir']));
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus.');
    }
}

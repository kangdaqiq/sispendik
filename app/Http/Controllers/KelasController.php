<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with(['tahunAjaran', 'jurusan', 'waliKelas'])->latest()->paginate(15);
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $jurusan = Jurusan::all();
        $guru = Guru::where('status', 'aktif')->get();
        $ta = TahunAjaran::all();
        return view('kelas.create', compact('jurusan', 'guru', 'ta'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'tingkat' => 'required|in:X,XI,XII',
            'nama' => 'required|string',
            'kapasitas' => 'nullable|integer|min:1',
        ]);
        Kelas::create($validated);
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kela)
    {
        $kela->load(['siswa', 'jadwal.mataPelajaran', 'jadwal.guru']);
        return view('kelas.show', ['kelas' => $kela]);
    }

    public function edit(Kelas $kela)
    {
        $jurusan = Jurusan::all();
        $guru = Guru::where('status', 'aktif')->get();
        $ta = TahunAjaran::all();
        return view('kelas.edit', ['kelas' => $kela, 'jurusan' => $jurusan, 'guru' => $guru, 'ta' => $ta]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'tingkat' => 'required|in:X,XI,XII',
            'nama' => 'required|string',
            'kapasitas' => 'nullable|integer|min:1',
        ]);
        $kela->update($validated);
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}

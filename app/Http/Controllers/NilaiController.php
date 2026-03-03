<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $ta = TahunAjaran::aktif();
        $kelas = Kelas::all();
        $query = Nilai::with(['siswa', 'mataPelajaran', 'kelas', 'guru'])->where('tahun_ajaran_id', $ta?->id);
        if ($request->kelas_id)
            $query->where('kelas_id', $request->kelas_id);
        if ($request->mata_pelajaran_id)
            $query->where('mata_pelajaran_id', $request->mata_pelajaran_id);
        $nilai = $query->latest()->paginate(20)->withQueryString();
        $mapel = MataPelajaran::all();
        return view('nilai.index', compact('nilai', 'kelas', 'mapel', 'ta'));
    }

    public function create()
    {
        $siswa = Siswa::where('status', 'aktif')->get();
        $mapel = MataPelajaran::all();
        $kelas = Kelas::all();
        $guru = Guru::where('status', 'aktif')->get();
        $ta = TahunAjaran::aktif();
        return view('nilai.create', compact('siswa', 'mapel', 'kelas', 'guru', 'ta'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai_uts' => 'nullable|numeric|min:0|max:100',
            'nilai_uas' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        Nilai::updateOrCreate(
            ['siswa_id' => $validated['siswa_id'], 'mata_pelajaran_id' => $validated['mata_pelajaran_id'], 'tahun_ajaran_id' => $validated['tahun_ajaran_id'], 'kelas_id' => $validated['kelas_id']],
            $validated
        );
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil disimpan.');
    }

    public function show(Nilai $nilai)
    {
        return view('nilai.show', compact('nilai'));
    }
    public function edit(Nilai $nilai)
    {
        $siswa = Siswa::all();
        $mapel = MataPelajaran::all();
        $kelas = Kelas::all();
        $guru = Guru::all();
        $ta = TahunAjaran::all();
        return view('nilai.edit', compact('nilai', 'siswa', 'mapel', 'kelas', 'guru', 'ta'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'nilai_tugas' => 'nullable|numeric|min:0|max:100',
            'nilai_uts' => 'nullable|numeric|min:0|max:100',
            'nilai_uas' => 'nullable|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        $nilai->update($validated);
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diupdate.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }
}

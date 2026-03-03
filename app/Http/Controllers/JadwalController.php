<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'guru', 'tahunAjaran'])->latest()->paginate(20);
        return view('jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::where('status', 'aktif')->get();
        $ta = TahunAjaran::aktif();
        return view('jadwal.create', compact('kelas', 'mapel', 'guru', 'ta'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
        Jadwal::create($validated);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function bulkCreate()
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::where('status', 'aktif')->get();
        $ta = TahunAjaran::aktif();
        return view('jadwal.bulk-create', compact('kelas', 'mapel', 'guru', 'ta'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'jadwal' => 'required|array|min:1',
            'jadwal.*.mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'jadwal.*.guru_id' => 'required|exists:guru,id',
            'jadwal.*.hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jadwal.*.jam_mulai' => 'required',
            'jadwal.*.jam_selesai' => 'required|after:jadwal.*.jam_mulai',
        ]);

        $kelas_id = $validated['kelas_id'];
        $tahun_ajaran_id = $validated['tahun_ajaran_id'];

        foreach ($validated['jadwal'] as $item) {
            Jadwal::create([
                'kelas_id' => $kelas_id,
                'tahun_ajaran_id' => $tahun_ajaran_id,
                'mata_pelajaran_id' => $item['mata_pelajaran_id'],
                'guru_id' => $item['guru_id'],
                'hari' => $item['hari'],
                'jam_mulai' => $item['jam_mulai'],
                'jam_selesai' => $item['jam_selesai'],
            ]);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal massal berhasil ditambahkan.');
    }

    public function show(Jadwal $jadwal)
    {
        return redirect()->route('jadwal.index');
    }

    public function edit(Jadwal $jadwal)
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru = Guru::where('status', 'aktif')->get();
        $ta = TahunAjaran::all();
        return view('jadwal.edit', compact('jadwal', 'kelas', 'mapel', 'guru', 'ta'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:guru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
        $jadwal->update($validated);
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}

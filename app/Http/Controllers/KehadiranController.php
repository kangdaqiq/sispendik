<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Guru;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    public function index(Request $request)
    {
        $query = Kehadiran::with(['siswa', 'kelas', 'jadwal']);
        if ($request->kelas_id)
            $query->where('kelas_id', $request->kelas_id);
        if ($request->tanggal)
            $query->whereDate('tanggal', $request->tanggal);
        $kehadiran = $query->latest()->paginate(20)->withQueryString();
        $kelas = Kelas::all();
        return view('kehadiran.index', compact('kehadiran', 'kelas'));
    }

    public function create()
    {
        $siswa = Siswa::where('status', 'aktif')->get();
        $kelas = Kelas::all();
        $jadwal = Jadwal::with(['mataPelajaran', 'kelas'])->get();
        return view('kehadiran.create', compact('siswa', 'kelas', 'jadwal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jadwal_id' => 'nullable|exists:jadwal,id',
            'guru_id' => 'nullable|exists:guru,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,sakit,izin,alpha',
            'keterangan' => 'nullable|string',
        ]);
        Kehadiran::updateOrCreate(
            ['siswa_id' => $validated['siswa_id'], 'jadwal_id' => $validated['jadwal_id'] ?? null, 'tanggal' => $validated['tanggal']],
            $validated
        );
        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil disimpan.');
    }

    public function show(Kehadiran $kehadiran)
    {
        return view('kehadiran.show', compact('kehadiran'));
    }
    public function edit(Kehadiran $kehadiran)
    {
        $siswa = Siswa::all();
        $kelas = Kelas::all();
        $jadwal = Jadwal::all();
        return view('kehadiran.edit', compact('kehadiran', 'siswa', 'kelas', 'jadwal'));
    }

    public function update(Request $request, Kehadiran $kehadiran)
    {
        $kehadiran->update($request->validate(['status' => 'required|in:hadir,sakit,izin,alpha', 'keterangan' => 'nullable|string']));
        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran berhasil diupdate.');
    }

    public function destroy(Kehadiran $kehadiran)
    {
        $kehadiran->delete();
        return redirect()->route('kehadiran.index')->with('success', 'Kehadiran dihapus.');
    }

    public function rekap(Request $request)
    {
        $kelas = Kelas::all();
        $data = [];
        if ($request->kelas_id) {
            $siswaList = Siswa::whereHas('kelas', fn($q) => $q->where('kelas.id', $request->kelas_id))->get();
            foreach ($siswaList as $s) {
                $data[] = [
                    'siswa' => $s,
                    'hadir' => Kehadiran::where('siswa_id', $s->id)->where('status', 'hadir')->count(),
                    'sakit' => Kehadiran::where('siswa_id', $s->id)->where('status', 'sakit')->count(),
                    'izin' => Kehadiran::where('siswa_id', $s->id)->where('status', 'izin')->count(),
                    'alpha' => Kehadiran::where('siswa_id', $s->id)->where('status', 'alpha')->count(),
                ];
            }
        }
        return view('kehadiran.rekap', compact('kelas', 'data'));
    }
}

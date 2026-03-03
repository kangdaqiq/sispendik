<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();
        if ($request->search) {
            $query->where('nama', 'like', "%{$request->search}%")
                ->orWhere('nis', 'like', "%{$request->search}%");
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        $siswa = $query->latest()->paginate(15)->withQueryString();
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa',
            'nisn' => 'nullable|unique:siswa',
            'nama' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'sekolah_asal' => 'nullable|string|max:255',
            'anak_ke' => 'nullable|integer',
            'dari_bersaudara' => 'nullable|integer',
            'status_anak' => 'nullable|in:kandung,tiri,angkat',
            'berat_badan' => 'nullable|integer',
            'tinggi_badan' => 'nullable|integer',

            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'alamat_detail' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',

            'status_ayah' => 'nullable|in:masih_hidup,sudah_meninggal',
            'nama_ayah' => 'nullable|string|max:255',
            'pendidikan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',

            'status_ibu' => 'nullable|in:masih_hidup,sudah_meninggal',
            'nama_ibu' => 'nullable|string|max:255',
            'pendidikan_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',

            'nama_ortu' => 'nullable|string',
            'no_telp_ayah' => 'nullable|string|max:20',
            'no_telp_ibu' => 'nullable|string|max:20',

            'nama_wali' => 'nullable|string|max:255',
            'pendidikan_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'no_telp_wali' => 'nullable|string|max:20',

            'alamat_ortu_sama' => 'nullable|boolean',
            'provinsi_ortu' => 'nullable|string|max:255',
            'kabupaten_ortu' => 'nullable|string|max:255',
            'kecamatan_ortu' => 'nullable|string|max:255',
            'desa_ortu' => 'nullable|string|max:255',
            'alamat_detail_ortu' => 'nullable|string',
            'rt_ortu' => 'nullable|string|max:5',
            'rw_ortu' => 'nullable|string|max:5',
            'kode_pos_ortu' => 'nullable|string|max:10',

            'foto' => 'nullable|image|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp_ortu' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah_terakhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('siswa', 'public');
        }
        if ($request->hasFile('foto_ktp_ortu')) {
            $validated['foto_ktp_ortu'] = $request->file('foto_ktp_ortu')->store('siswa', 'public');
        }
        if ($request->hasFile('ijazah_terakhir')) {
            $validated['ijazah_terakhir'] = $request->file('ijazah_terakhir')->store('siswa', 'public');
        }

        // Handle disabled fields not being submitted if alamat_ortu_sama is true
        if (!empty($validated['alamat_ortu_sama'])) {
            $validated['provinsi_ortu'] = $validated['provinsi'] ?? null;
            $validated['kabupaten_ortu'] = $validated['kabupaten'] ?? null;
            $validated['kecamatan_ortu'] = $validated['kecamatan'] ?? null;
            $validated['desa_ortu'] = $validated['desa'] ?? null;
            $validated['alamat_detail_ortu'] = $validated['alamat_detail'] ?? null;
            $validated['rt_ortu'] = $validated['rt'] ?? null;
            $validated['rw_ortu'] = $validated['rw'] ?? null;
            $validated['kode_pos_ortu'] = $validated['kode_pos'] ?? null;
        }

        Siswa::create($validated);
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas.tahunAjaran', 'nilai.mataPelajaran', 'kehadiran']);
        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nisn' => 'nullable|unique:siswa,nisn,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'sekolah_asal' => 'nullable|string|max:255',
            'anak_ke' => 'nullable|integer',
            'dari_bersaudara' => 'nullable|integer',
            'status_anak' => 'nullable|in:kandung,tiri,angkat',
            'berat_badan' => 'nullable|integer',
            'tinggi_badan' => 'nullable|integer',

            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'alamat_detail' => 'nullable|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',

            'status_ayah' => 'nullable|in:masih_hidup,sudah_meninggal',
            'nama_ayah' => 'nullable|string|max:255',
            'pendidikan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',

            'status_ibu' => 'nullable|in:masih_hidup,sudah_meninggal',
            'nama_ibu' => 'nullable|string|max:255',
            'pendidikan_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',

            'nama_ortu' => 'nullable|string',
            'no_telp_ayah' => 'nullable|string|max:20',
            'no_telp_ibu' => 'nullable|string|max:20',

            'nama_wali' => 'nullable|string|max:255',
            'pendidikan_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'no_telp_wali' => 'nullable|string|max:20',

            'alamat_ortu_sama' => 'nullable|boolean',
            'provinsi_ortu' => 'nullable|string|max:255',
            'kabupaten_ortu' => 'nullable|string|max:255',
            'kecamatan_ortu' => 'nullable|string|max:255',
            'desa_ortu' => 'nullable|string|max:255',
            'alamat_detail_ortu' => 'nullable|string',
            'rt_ortu' => 'nullable|string|max:5',
            'rw_ortu' => 'nullable|string|max:5',
            'kode_pos_ortu' => 'nullable|string|max:10',

            'foto' => 'nullable|image|max:2048',
            'foto_kk' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp_ortu' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'ijazah_terakhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif,lulus,pindah',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }
        if ($request->hasFile('foto_kk')) {
            $validated['foto_kk'] = $request->file('foto_kk')->store('siswa', 'public');
        }
        if ($request->hasFile('foto_ktp_ortu')) {
            $validated['foto_ktp_ortu'] = $request->file('foto_ktp_ortu')->store('siswa', 'public');
        }
        if ($request->hasFile('ijazah_terakhir')) {
            $validated['ijazah_terakhir'] = $request->file('ijazah_terakhir')->store('siswa', 'public');
        }

        // Handle disabled fields not being submitted if alamat_ortu_sama is true
        if (!empty($validated['alamat_ortu_sama'])) {
            $validated['provinsi_ortu'] = $validated['provinsi'] ?? $siswa->provinsi ?? null;
            $validated['kabupaten_ortu'] = $validated['kabupaten'] ?? $siswa->kabupaten ?? null;
            $validated['kecamatan_ortu'] = $validated['kecamatan'] ?? $siswa->kecamatan ?? null;
            $validated['desa_ortu'] = $validated['desa'] ?? $siswa->desa ?? null;
            $validated['alamat_detail_ortu'] = $validated['alamat_detail'] ?? $siswa->alamat_detail ?? null;
            $validated['rt_ortu'] = $validated['rt'] ?? $siswa->rt ?? null;
            $validated['rw_ortu'] = $validated['rw'] ?? $siswa->rw ?? null;
            $validated['kode_pos_ortu'] = $validated['kode_pos'] ?? $siswa->kode_pos ?? null;
        }

        $siswa->update($validated);
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus.');
    }
}

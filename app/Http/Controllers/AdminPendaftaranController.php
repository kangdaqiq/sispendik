<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPendaftaranController extends Controller
{
    public function index()
    {
        $pendaftarans = Pendaftaran::latest()->get();
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function terima(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis'
        ]);

        // Create User account for the student
        $user = User::create([
            'name' => $pendaftaran->nama,
            'email' => strtolower(str_replace(' ', '', $pendaftaran->nama)) . rand(100, 999) . '@siswa.com',
            'password' => Hash::make('password123'), // Default password
            'role' => 'siswa'
        ]);

        // Format address
        $alamat = $pendaftaran->alamat_detail . ', ' . $pendaftaran->desa . ', ' . $pendaftaran->kecamatan . ', ' . $pendaftaran->kabupaten . ', ' . $pendaftaran->provinsi;

        // Create Siswa record
        Siswa::create([
            'nis' => $request->nis,
            'nisn' => $pendaftaran->nik, // We use NIK or a generic value since NISN usually comes later, using NIK temporarily if NISN is missing
            'nama' => $pendaftaran->nama,
            'nama_panggilan' => $pendaftaran->nama_panggilan,
            'jenis_kelamin' => $pendaftaran->jenis_kelamin,
            'tempat_lahir' => $pendaftaran->tempat_lahir,
            'tanggal_lahir' => $pendaftaran->tanggal_lahir,
            'agama' => $pendaftaran->agama,
            'no_telp' => $pendaftaran->no_telp,
            'sekolah_asal' => $pendaftaran->sekolah_asal,
            'anak_ke' => $pendaftaran->anak_ke,
            'dari_bersaudara' => $pendaftaran->dari_bersaudara,
            'status_anak' => $pendaftaran->status_anak,
            'berat_badan' => $pendaftaran->berat_badan,
            'tinggi_badan' => $pendaftaran->tinggi_badan,

            'alamat' => $alamat,
            'provinsi' => $pendaftaran->provinsi,
            'kabupaten' => $pendaftaran->kabupaten,
            'kecamatan' => $pendaftaran->kecamatan,
            'desa' => $pendaftaran->desa,
            'alamat_detail' => $pendaftaran->alamat_detail,
            'rt' => $pendaftaran->rt,
            'rw' => $pendaftaran->rw,
            'kode_pos' => $pendaftaran->kode_pos,

            'status_ayah' => $pendaftaran->status_ayah,
            'nama_ayah' => $pendaftaran->nama_ayah,
            'pendidikan_ayah' => $pendaftaran->pendidikan_ayah,
            'pekerjaan_ayah' => $pendaftaran->pekerjaan_ayah,
            'no_telp_ayah' => $pendaftaran->no_telp_ayah,

            'status_ibu' => $pendaftaran->status_ibu,
            'nama_ibu' => $pendaftaran->nama_ibu,
            'pendidikan_ibu' => $pendaftaran->pendidikan_ibu,
            'pekerjaan_ibu' => $pendaftaran->pekerjaan_ibu,
            'no_telp_ibu' => $pendaftaran->no_telp_ibu,

            'nama_ortu' => $pendaftaran->status_ayah == 'masih_hidup' ? $pendaftaran->nama_ayah : ($pendaftaran->status_ibu == 'masih_hidup' ? $pendaftaran->nama_ibu : $pendaftaran->nama_wali),
            // We can still map no_telp_ortu for legacy compatibility, but focus on the specific ones
            'no_telp_ortu' => $pendaftaran->no_telp_ayah ?? $pendaftaran->no_telp_ibu ?? $pendaftaran->no_telp_wali,

            'nama_wali' => $pendaftaran->nama_wali,
            'pendidikan_wali' => $pendaftaran->pendidikan_wali,
            'pekerjaan_wali' => $pendaftaran->pekerjaan_wali,
            'no_telp_wali' => $pendaftaran->no_telp_wali,

            'alamat_ortu_sama' => $pendaftaran->alamat_ortu_sama,
            'provinsi_ortu' => $pendaftaran->provinsi_ortu,
            'kabupaten_ortu' => $pendaftaran->kabupaten_ortu,
            'kecamatan_ortu' => $pendaftaran->kecamatan_ortu,
            'desa_ortu' => $pendaftaran->desa_ortu,
            'alamat_detail_ortu' => $pendaftaran->alamat_detail_ortu,
            'rt_ortu' => $pendaftaran->rt_ortu,
            'rw_ortu' => $pendaftaran->rw_ortu,
            'kode_pos_ortu' => $pendaftaran->kode_pos_ortu,

            'foto' => $pendaftaran->foto,
            'foto_kk' => $pendaftaran->foto_kk,
            'foto_ktp_ortu' => $pendaftaran->foto_ktp_ortu,
            'ijazah_terakhir' => $pendaftaran->ijazah_terakhir,

            'status' => 'aktif',
            'user_id' => $user->id
        ]);

        // Update registration status
        $pendaftaran->update(['status' => 'diterima']);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Siswa berhasil diterima dan akun telah dibuat.');
    }

    public function tolak(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update(['status' => 'ditolak']);
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Pendaftaran berhasil ditolak.');
    }
}

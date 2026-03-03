<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'no_telp',
        'sekolah_asal',
        'anak_ke',
        'dari_bersaudara',
        'status_anak',
        'berat_badan',
        'tinggi_badan',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'alamat_detail',
        'rt',
        'rw',
        'kode_pos',
        'status_ayah',
        'nama_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'status_ibu',
        'nama_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'nama_ortu',
        'no_telp_ayah',
        'no_telp_ibu',
        'nama_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'no_telp_wali',
        'alamat_ortu_sama',
        'provinsi_ortu',
        'kabupaten_ortu',
        'kecamatan_ortu',
        'desa_ortu',
        'alamat_detail_ortu',
        'rt_ortu',
        'rw_ortu',
        'kode_pos_ortu',
        'foto',
        'foto_kk',
        'foto_ktp_ortu',
        'ijazah_terakhir',
        'status',
        'user_id'
    ];
    protected $casts = ['tanggal_lahir' => 'date'];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_siswa')->withPivot('nomor_absen', 'tahun_ajaran_id')->withTimestamps();
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function kelasAktif()
    {
        $ta = TahunAjaran::aktif();
        return $ta ? $this->kelas()->where('kelas_siswa.tahun_ajaran_id', $ta->id)->first() : null;
    }
}

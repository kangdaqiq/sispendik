<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['tahun_ajaran_id', 'jurusan_id', 'wali_kelas_id', 'tingkat', 'nama', 'kapasitas'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }
    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'kelas_siswa')->withPivot('nomor_absen', 'tahun_ajaran_id')->withTimestamps();
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }
}

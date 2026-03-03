<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = [
        'siswa_id',
        'mata_pelajaran_id',
        'guru_id',
        'kelas_id',
        'tahun_ajaran_id',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'predikat',
        'catatan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    protected static function booted()
    {
        static::saving(function ($nilai) {
            if ($nilai->nilai_tugas !== null && $nilai->nilai_uts !== null && $nilai->nilai_uas !== null) {
                $avg = ($nilai->nilai_tugas * 0.3) + ($nilai->nilai_uts * 0.3) + ($nilai->nilai_uas * 0.4);
                $nilai->nilai_akhir = round($avg, 2);
                $nilai->predikat = match (true) {
                    $avg >= 90 => 'A',
                    $avg >= 80 => 'B',
                    $avg >= 70 => 'C',
                    $avg >= 60 => 'D',
                    default => 'E',
                };
            }
        });
    }
}

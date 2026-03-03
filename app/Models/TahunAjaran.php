<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $fillable = ['nama', 'semester', 'tanggal_mulai', 'tanggal_selesai', 'is_aktif'];
    protected $casts = ['is_aktif' => 'boolean', 'tanggal_mulai' => 'date', 'tanggal_selesai' => 'date'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
    public function kelasSiswa()
    {
        return $this->hasMany(KelasSiswa::class);
    }

    public static function aktif()
    {
        return static::where('is_aktif', true)->first();
    }
}

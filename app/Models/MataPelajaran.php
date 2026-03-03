<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['kode', 'nama', 'kelompok', 'kkm', 'jam_per_minggu', 'deskripsi'];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
}

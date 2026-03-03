<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
        'no_telp',
        'email',
        'pendidikan_terakhir',
        'foto',
        'status',
        'user_id'
    ];
    protected $casts = ['tanggal_lahir' => 'date'];

    public function kelasWali()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

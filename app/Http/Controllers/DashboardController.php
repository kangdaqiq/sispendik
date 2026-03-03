<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Kehadiran;
use App\Models\Nilai;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_siswa' => Siswa::where('status', 'aktif')->count(),
            'total_guru' => Guru::where('status', 'aktif')->count(),
            'total_kelas' => Kelas::count(),
            'tahun_ajaran' => TahunAjaran::aktif(),
        ];
        return view('dashboard', compact('data'));
    }
}

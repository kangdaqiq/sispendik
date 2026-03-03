<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@sispendik.com'],
            ['name' => 'Administrator', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // 2. Jurusan
        $jurusanIPA = Jurusan::firstOrCreate(['kode' => 'IPA'], ['nama' => 'Matematika dan Ilmu Pengetahuan Alam', 'deskripsi' => 'Fokus pada sains']);
        $jurusanIPS = Jurusan::firstOrCreate(['kode' => 'IPS'], ['nama' => 'Ilmu Pengetahuan Sosial', 'deskripsi' => 'Fokus pada humaniora']);

        // 3. Tahun Ajaran
        $ta = TahunAjaran::firstOrCreate(
            ['nama' => '2025/2026', 'semester' => 'ganjil'],
            ['tanggal_mulai' => '2025-07-15', 'tanggal_selesai' => '2025-12-20', 'is_aktif' => true]
        );

        // 4. Mata Pelajaran
        $matematika = MataPelajaran::firstOrCreate(['kode' => 'MTK'], ['nama' => 'Matematika', 'kelompok' => 'A', 'kkm' => 75, 'jam_per_minggu' => 4]);
        $bahasa_indonesia = MataPelajaran::firstOrCreate(['kode' => 'BIN'], ['nama' => 'Bahasa Indonesia', 'kelompok' => 'A', 'kkm' => 75, 'jam_per_minggu' => 4]);

        // 5. Guru
        $userGuru1 = User::firstOrCreate(
            ['email' => 'guru1@sispendik.com'],
            ['name' => 'Budi Santoso, S.Pd', 'password' => Hash::make('password'), 'role' => 'guru']
        );
        $guru1 = Guru::firstOrCreate(
            ['nip' => '198001012005011001'],
            ['user_id' => $userGuru1->id, 'nama' => 'Budi Santoso, S.Pd', 'jenis_kelamin' => 'L', 'pendidikan_terakhir' => 'S1 Pendidikan Matematika', 'status' => 'aktif']
        );

        $userGuru2 = User::firstOrCreate(
            ['email' => 'guru2@sispendik.com'],
            ['name' => 'Siti Aminah, M.Pd', 'password' => Hash::make('password'), 'role' => 'guru']
        );
        $guru2 = Guru::firstOrCreate(
            ['nip' => '198502022010012002'],
            ['user_id' => $userGuru2->id, 'nama' => 'Siti Aminah, M.Pd', 'jenis_kelamin' => 'P', 'pendidikan_terakhir' => 'S2 Pendidikan Bahasa', 'status' => 'aktif']
        );

        // 6. Kelas
        $kelasXIPA1 = Kelas::firstOrCreate(
            ['nama' => 'X-IPA-1', 'tahun_ajaran_id' => $ta->id],
            ['jurusan_id' => $jurusanIPA->id, 'wali_kelas_id' => $guru1->id, 'tingkat' => 'X', 'kapasitas' => 30]
        );

        // 7. Siswa
        $userSiswa1 = User::firstOrCreate(
            ['email' => 'siswa1@sispendik.com'],
            ['name' => 'Ahmad Fais', 'password' => Hash::make('password'), 'role' => 'siswa']
        );
        $siswa1 = Siswa::firstOrCreate(
            ['nis' => '10001', 'nisn' => '0051234567'],
            ['user_id' => $userSiswa1->id, 'nama' => 'Ahmad Fais', 'jenis_kelamin' => 'L', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '2005-05-15', 'status' => 'aktif']
        );

        $userSiswa2 = User::firstOrCreate(
            ['email' => 'siswa2@sispendik.com'],
            ['name' => 'Bunga Lestari', 'password' => Hash::make('password'), 'role' => 'siswa']
        );
        $siswa2 = Siswa::firstOrCreate(
            ['nis' => '10002', 'nisn' => '0057654321'],
            ['user_id' => $userSiswa2->id, 'nama' => 'Bunga Lestari', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '2005-08-20', 'status' => 'aktif']
        );

        // Attach Siswa ke Kelas
        $kelasXIPA1->siswa()->syncWithoutDetaching([
            $siswa1->id => ['tahun_ajaran_id' => $ta->id],
            $siswa2->id => ['tahun_ajaran_id' => $ta->id],
        ]);
    }
}

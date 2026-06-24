<?php

namespace Tests\Feature;

use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Jobs\SendWhatsAppPendaftaranNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PendaftaranTest extends TestCase
{
    use RefreshDatabase;

    private function createTestJurusan()
    {
        return Jurusan::create([
            'kode' => 'TKJ',
            'nama' => 'Teknik Komputer & Jaringan',
            'deskripsi' => 'Testing'
        ]);
    }

    public function test_pendaftaran_page_is_accessible(): void
    {
        $response = $this->get('/pendaftaran');

        $response->assertStatus(200);
        $response->assertSee('pendaftaran');
    }

    public function test_pendaftaran_validation_errors_if_empty(): void
    {
        $response = $this->post('/pendaftaran', []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'jurusan_id', 'nik', 'no_kk', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'agama',
            'no_telp', 'sekolah_asal', 'anak_ke', 'dari_bersaudara', 'status_anak', 'berat_badan',
            'tinggi_badan', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'alamat_detail',
            'status_ayah', 'nama_ayah', 'status_ibu', 'nama_ibu'
        ]);
    }

    public function test_pendaftaran_submission_success(): void
    {
        Queue::fake();
        Storage::fake('public');

        $jurusan = $this->createTestJurusan();

        $payload = [
            'jurusan_id' => $jurusan->id,
            'nik' => '1234567890123456',
            'nisn' => '00987654321',
            'no_kk' => '6543210987654321',
            'nama' => 'Ahmad Dani',
            'nama_panggilan' => 'Ahmad',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2010-05-15',
            'agama' => 'Islam',
            'no_telp' => '081234567890',
            'sekolah_asal' => 'SMPN 1 Sidoarjo',
            'anak_ke' => 1,
            'dari_bersaudara' => 2,
            'status_anak' => 'kandung',
            'berat_badan' => 45,
            'tinggi_badan' => 155,

            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Candi',
            'desa' => 'Gelam',
            'alamat_detail' => 'Perumahan Gelam Jaya Indah Blok B-12',
            'rt' => '02',
            'rw' => '05',
            'kode_pos' => '61271',

            'status_ayah' => 'masih_hidup',
            'nama_ayah' => 'Budi Santoso',
            'pendidikan_ayah' => 'SMA/SMK/Sederajat',
            'pekerjaan_ayah' => 'Wiraswasta / Wirausaha',
            'penghasilan_ayah' => 'Rp2.000.000 – Rp4.999.999',
            'no_telp_ayah' => '081234567891',

            'status_ibu' => 'masih_hidup',
            'nama_ibu' => 'Siti Aminah',
            'pendidikan_ibu' => 'SMA/SMK/Sederajat',
            'pekerjaan_ibu' => 'Tidak Bekerja / Ibu Rumah Tangga',
            'penghasilan_ibu' => 'Tidak Berpenghasilan',
            'no_telp_ibu' => '081234567892',

            'alamat_ortu_sama' => 1,

            'foto_kk' => UploadedFile::fake()->create('kk.jpg', 100, 'image/jpeg'),
            'foto_ktp_ortu' => UploadedFile::fake()->create('ktp.jpg', 100, 'image/jpeg'),
            'ijazah_terakhir' => UploadedFile::fake()->create('ijazah.jpg', 100, 'image/jpeg'),
            'foto_akte_kelahiran' => UploadedFile::fake()->create('akte.jpg', 100, 'image/jpeg'),
        ];

        $response = $this->post('/pendaftaran', $payload);

        $response->assertRedirect('/pendaftaran/sukses');
        $this->assertDatabaseHas('pendaftarans', [
            'nik' => '1234567890123456',
            'nama' => 'Ahmad Dani',
            'status' => 'pending'
        ]);

        $pendaftaran = Pendaftaran::where('nik', '1234567890123456')->first();
        $this->assertNotNull($pendaftaran);

        // Check if files are uploaded
        Storage::disk('public')->assertExists($pendaftaran->foto_kk);
        Storage::disk('public')->assertExists($pendaftaran->foto_ktp_ortu);
        Storage::disk('public')->assertExists($pendaftaran->ijazah_terakhir);
        Storage::disk('public')->assertExists($pendaftaran->foto_akte_kelahiran);

        // Check if job is pushed
        Queue::assertPushed(SendWhatsAppPendaftaranNotification::class, function ($job) use ($pendaftaran) {
            return $job->pendaftaran->id === $pendaftaran->id;
        });
    }

    public function test_pendaftaran_with_referral_code(): void
    {
        Queue::fake();
        Storage::fake('public');

        $jurusan = $this->createTestJurusan();

        $referral = \App\Models\ReferralLink::create([
            'code' => 'KANGDAQIQ',
            'nama' => 'Test Referral',
            'keterangan' => 'Test description'
        ]);

        $payload = [
            'jurusan_id' => $jurusan->id,
            'nik' => '1234567890123457',
            'no_kk' => '6543210987654321',
            'nama' => 'Ahmad Dani 2',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2010-05-15',
            'agama' => 'Islam',
            'no_telp' => '081234567890',
            'sekolah_asal' => 'SMPN 1 Sidoarjo',
            'anak_ke' => 1,
            'dari_bersaudara' => 2,
            'status_anak' => 'kandung',
            'berat_badan' => 45,
            'tinggi_badan' => 155,
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Candi',
            'desa' => 'Gelam',
            'alamat_detail' => 'Perumahan Gelam Jaya Indah',
            'status_ayah' => 'masih_hidup',
            'nama_ayah' => 'Budi Santoso',
            'pendidikan_ayah' => 'SMA/SMK/Sederajat',
            'pekerjaan_ayah' => 'Wiraswasta / Wirausaha',
            'penghasilan_ayah' => 'Rp2.000.000 – Rp4.999.999',
            'no_telp_ayah' => '081234567891',
            'status_ibu' => 'masih_hidup',
            'nama_ibu' => 'Siti Aminah',
            'pendidikan_ibu' => 'SMA/SMK/Sederajat',
            'pekerjaan_ibu' => 'Tidak Bekerja / Ibu Rumah Tangga',
            'penghasilan_ibu' => 'Tidak Berpenghasilan',
            'no_telp_ibu' => '081234567892',
            'alamat_ortu_sama' => 1,
            'referral_code' => 'KANGDAQIQ',
            'foto_kk' => UploadedFile::fake()->create('kk.jpg', 100, 'image/jpeg'),
            'foto_ktp_ortu' => UploadedFile::fake()->create('ktp.jpg', 100, 'image/jpeg'),
            'ijazah_terakhir' => UploadedFile::fake()->create('ijazah.jpg', 100, 'image/jpeg'),
            'foto_akte_kelahiran' => UploadedFile::fake()->create('akte.jpg', 100, 'image/jpeg'),
        ];

        $response = $this->post('/pendaftaran', $payload);

        $response->assertRedirect('/pendaftaran/sukses');
        $this->assertDatabaseHas('pendaftarans', [
            'nik' => '1234567890123457',
            'referral_code' => 'KANGDAQIQ',
        ]);
    }

    public function test_pendaftaran_submission_without_ijazah_terakhir_success(): void
    {
        Queue::fake();
        Storage::fake('public');

        $jurusan = $this->createTestJurusan();

        $payload = [
            'jurusan_id' => $jurusan->id,
            'nik' => '1234567890123458',
            'no_kk' => '6543210987654321',
            'nama' => 'Ahmad Dani 3',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2010-05-15',
            'agama' => 'Islam',
            'no_telp' => '081234567890',
            'sekolah_asal' => 'SMPN 1 Sidoarjo',
            'anak_ke' => 1,
            'dari_bersaudara' => 2,
            'status_anak' => 'kandung',
            'berat_badan' => 45,
            'tinggi_badan' => 155,
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Candi',
            'desa' => 'Gelam',
            'alamat_detail' => 'Perumahan Gelam Jaya Indah',
            'status_ayah' => 'masih_hidup',
            'nama_ayah' => 'Budi Santoso',
            'pendidikan_ayah' => 'SMA/SMK/Sederajat',
            'pekerjaan_ayah' => 'Wiraswasta / Wirausaha',
            'penghasilan_ayah' => 'Rp2.000.000 – Rp4.999.999',
            'no_telp_ayah' => '081234567891',
            'status_ibu' => 'masih_hidup',
            'nama_ibu' => 'Siti Aminah',
            'pendidikan_ibu' => 'SMA/SMK/Sederajat',
            'pekerjaan_ibu' => 'Tidak Bekerja / Ibu Rumah Tangga',
            'penghasilan_ibu' => 'Tidak Berpenghasilan',
            'no_telp_ibu' => '081234567892',
            'alamat_ortu_sama' => 1,
            'foto_kk' => UploadedFile::fake()->create('kk.jpg', 100, 'image/jpeg'),
            'foto_ktp_ortu' => UploadedFile::fake()->create('ktp.jpg', 100, 'image/jpeg'),
            'foto_akte_kelahiran' => UploadedFile::fake()->create('akte.jpg', 100, 'image/jpeg'),
            // ijazah_terakhir omitted
        ];

        $response = $this->post('/pendaftaran', $payload);

        $response->assertRedirect('/pendaftaran/sukses');
        $this->assertDatabaseHas('pendaftarans', [
            'nik' => '1234567890123458',
            'ijazah_terakhir' => null,
        ]);
    }

    public function test_send_whatsapp_pendaftaran_notification_job(): void
    {
        Storage::fake('public');

        $jurusan = $this->createTestJurusan();
        $pendaftaran = Pendaftaran::create([
            'jurusan_id' => $jurusan->id,
            'nik' => '1234567890123456',
            'nisn' => '00987654321',
            'no_kk' => '6543210987654321',
            'nama' => 'Ahmad Dani',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2010-05-15',
            'agama' => 'Islam',
            'no_telp' => '081234567890',
            'sekolah_asal' => 'SMPN 1 Sidoarjo',
            'anak_ke' => 1,
            'dari_bersaudara' => 2,
            'status_anak' => 'kandung',
            'berat_badan' => 45,
            'tinggi_badan' => 155,
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Candi',
            'desa' => 'Gelam',
            'alamat_detail' => 'Perumahan Gelam Jaya Indah',
            'status_ayah' => 'masih_hidup',
            'nama_ayah' => 'Budi Santoso',
            'status_ibu' => 'masih_hidup',
            'nama_ibu' => 'Siti Aminah',
            'foto_kk' => 'temp/kk.jpg',
            'foto_ktp_ortu' => 'temp/ktp.jpg',
            'foto_akte_kelahiran' => 'temp/akte.jpg',
        ]);

        $groupGuru = '6281369368296-1504440561@g.us';
        config(['services.whatsapp.group_guru' => $groupGuru]);

        $sentMessages = [];
        $mockWa = $this->createMock(\App\Services\WhatsAppService::class);
        $mockWa->method('sendMessage')
            ->willReturnCallback(function ($phone, $message) use (&$sentMessages) {
                $sentMessages[] = [
                    'phone' => $phone,
                    'message' => $message
                ];
                return true;
            });

        $mockWa->method('sendFile')
            ->willReturn(true);

        $job = new SendWhatsAppPendaftaranNotification($pendaftaran);
        $job->handle($mockWa);

        $this->assertCount(2, $sentMessages);
        $this->assertEquals('081234567890', $sentMessages[0]['phone']);
        $this->assertStringContainsString('Ahmad Dani', $sentMessages[0]['message']);
        $this->assertEquals($groupGuru, $sentMessages[1]['phone']);
        $this->assertStringContainsString('PENDAFTARAN SISWA BARU', $sentMessages[1]['message']);
        $this->assertStringContainsString('Ahmad Dani', $sentMessages[1]['message']);
        $this->assertStringContainsString('Teknik Komputer & Jaringan', $sentMessages[1]['message']);
    }

    public function test_resend_notification_artisan_command(): void
    {
        Storage::fake('public');

        $jurusan = $this->createTestJurusan();
        $pendaftaran = Pendaftaran::create([
            'jurusan_id' => $jurusan->id,
            'nik' => '1234567890123456',
            'nisn' => '00987654321',
            'no_kk' => '6543210987654321',
            'nama' => 'Ahmad Dani',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2010-05-15',
            'agama' => 'Islam',
            'no_telp' => '081234567890',
            'sekolah_asal' => 'SMPN 1 Sidoarjo',
            'anak_ke' => 1,
            'dari_bersaudara' => 2,
            'status_anak' => 'kandung',
            'berat_badan' => 45,
            'tinggi_badan' => 155,
            'provinsi' => 'Jawa Timur',
            'kabupaten' => 'Sidoarjo',
            'kecamatan' => 'Candi',
            'desa' => 'Gelam',
            'alamat_detail' => 'Perumahan Gelam Jaya Indah',
            'status_ayah' => 'masih_hidup',
            'nama_ayah' => 'Budi Santoso',
            'status_ibu' => 'masih_hidup',
            'nama_ibu' => 'Siti Aminah',
            'foto_kk' => 'temp/kk.jpg',
            'foto_ktp_ortu' => 'temp/ktp.jpg',
            'foto_akte_kelahiran' => 'temp/akte.jpg',
        ]);

        $groupGuru = '6281369368296-1504440561@g.us';
        config(['services.whatsapp.group_guru' => $groupGuru]);

        // Mock WhatsAppService dependency
        $sentMessages = [];
        $mockWa = $this->createMock(\App\Services\WhatsAppService::class);
        $mockWa->method('sendMessage')
            ->willReturnCallback(function ($phone, $message) use (&$sentMessages) {
                $sentMessages[] = [
                    'phone' => $phone,
                    'message' => $message
                ];
                return true;
            });
        $mockWa->method('sendFile')->willReturn(true);

        $this->app->instance(\App\Services\WhatsAppService::class, $mockWa);

        // Run command
        $this->artisan('pendaftaran:resend-notif', [
            '--id' => [$pendaftaran->id],
            '--group-only' => true
        ])
        ->expectsOutput("- Mengirim notifikasi untuk: Ahmad Dani (ID: {$pendaftaran->id})")
        ->assertExitCode(0);

        // Should only send 1 message (to group) and 0 files (none to student)
        $this->assertCount(1, $sentMessages);
        $this->assertEquals($groupGuru, $sentMessages[0]['phone']);
        $this->assertStringContainsString('PENDAFTARAN SISWA BARU', $sentMessages[0]['message']);
    }
}

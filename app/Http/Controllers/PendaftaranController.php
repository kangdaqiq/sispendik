<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function create(Request $request)
    {
        $referralCode = $request->query('ref', '');
        return view('pendaftaran.create', compact('referralCode'));
    }

    public function createWithReferral(string $code)
    {
        $referralCode = $code;
        return view('pendaftaran.create', compact('referralCode'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nik' => 'required|string|unique:pendaftarans,nik',
            'nisn' => 'nullable|string|unique:pendaftarans,nisn',
            'no_kk' => 'required|string',
            'nama' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'sekolah_asal' => 'required|string|max:255',
            'anak_ke' => 'required|integer',
            'dari_bersaudara' => 'required|integer',
            'status_anak' => 'required|in:kandung,tiri,angkat',
            'berat_badan' => 'required|integer',
            'tinggi_badan' => 'required|integer',

            'provinsi' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'alamat_detail' => 'required|string',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:10',

            'status_ayah' => 'required|in:masih_hidup,sudah_meninggal',
            'nama_ayah' => 'required|string|max:255',
            'pendidikan_ayah' => 'required_if:status_ayah,masih_hidup|nullable|string|max:255',
            'pekerjaan_ayah' => 'required_if:status_ayah,masih_hidup|nullable|string|max:255',
            'pekerjaan_ayah_lainnya' => 'nullable|string|max:255',
            'penghasilan_ayah' => 'required_if:status_ayah,masih_hidup|nullable|string|max:255',

            'status_ibu' => 'required|in:masih_hidup,sudah_meninggal',
            'nama_ibu' => 'required|string|max:255',
            'pendidikan_ibu' => 'required_if:status_ibu,masih_hidup|nullable|string|max:255',
            'pekerjaan_ibu' => 'required_if:status_ibu,masih_hidup|nullable|string|max:255',
            'pekerjaan_ibu_lainnya' => 'nullable|string|max:255',
            'penghasilan_ibu' => 'required_if:status_ibu,masih_hidup|nullable|string|max:255',

            'no_telp_ayah' => 'nullable|string|max:20',
            'no_telp_ibu' => 'nullable|string|max:20',

            // Wali required if both parents deceased
            'nama_wali' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->status_ayah == 'sudah_meninggal' && $request->status_ibu == 'sudah_meninggal' && empty($value)) {
                        $fail('Nama wali wajib diisi jika kedua orang tua sudah meninggal.');
                    }
                },
            ],
            'pendidikan_wali' => 'nullable|string|max:255',
            'pekerjaan_wali' => 'nullable|string|max:255',
            'pekerjaan_wali_lainnya' => 'nullable|string|max:255',
            'penghasilan_wali' => 'nullable|string|max:255',
            'no_telp_wali' => 'nullable|string|max:20',

            'alamat_ortu_sama' => 'nullable|boolean',
        ];

        // Address sync logic
        $alamatSama = (int) $request->input('alamat_ortu_sama', 0);
        if ($alamatSama == 0) {
            $rules['provinsi_ortu'] = 'required|string|max:255';
            $rules['kabupaten_ortu'] = 'required|string|max:255';
            $rules['kecamatan_ortu'] = 'required|string|max:255';
            $rules['desa_ortu'] = 'required|string|max:255';
            $rules['alamat_detail_ortu'] = 'required|string';
            $rules['rt_ortu'] = 'nullable|string|max:5';
            $rules['rw_ortu'] = 'nullable|string|max:5';
            $rules['kode_pos_ortu'] = 'nullable|string|max:10';
        }

        // File Validation Logic with Temporary Support
        $rules['foto_kk'] = $request->input('temp_foto_kk') ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048';
        $rules['ijazah_terakhir'] = $request->input('temp_ijazah_terakhir') ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048';
        $rules['foto_akte_kelahiran'] = $request->input('temp_foto_akte_kelahiran') ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048';

        $rules['foto_ktp_ortu'] = [
            $request->input('temp_foto_ktp_ortu') ? 'nullable' : 'nullable', // Actually, handled by closure checking
            'image',
            'mimes:jpeg,png,jpg',
            'max:2048',
            function ($attribute, $value, $fail) use ($request) {
                if (($request->status_ayah == 'masih_hidup' || $request->status_ibu == 'masih_hidup') && empty($value) && empty($request->input('temp_foto_ktp_ortu'))) {
                    $fail('Foto KTP Ortu wajib diupload jika orang tua masih hidup.');
                }
            }
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Check if there are newly uploaded VALID files, save them to temp dir
            $tempFiles = [];
            $fileKeys = ['foto_kk', 'foto_ktp_ortu', 'ijazah_terakhir', 'foto_akte_kelahiran'];

            foreach ($fileKeys as $key) {
                if ($request->hasFile($key) && empty($validator->errors()->get($key))) {
                    $path = $request->file($key)->store('temp_pendaftaran', 'public');
                    $tempFiles['temp_' . $key] = $path;
                    $tempFiles['temp_' . $key . '_name'] = $request->file($key)->getClientOriginalName();
                } elseif ($request->input('temp_' . $key)) {
                    // Retain existing temp files if re-submitted without new upload
                    $tempFiles['temp_' . $key] = $request->input('temp_' . $key);
                    if ($request->input('temp_' . $key . '_name')) {
                        $tempFiles['temp_' . $key . '_name'] = $request->input('temp_' . $key . '_name');
                    }
                }
            }

            if (!empty($tempFiles)) {
                $request->merge($tempFiles);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        if (($validated['pekerjaan_ayah'] ?? '') === 'Lainnya') {
            $validated['pekerjaan_ayah'] = $validated['pekerjaan_ayah_lainnya'] ?? 'Lainnya';
        }
        if (($validated['pekerjaan_ibu'] ?? '') === 'Lainnya') {
            $validated['pekerjaan_ibu'] = $validated['pekerjaan_ibu_lainnya'] ?? 'Lainnya';
        }
        if (($validated['pekerjaan_wali'] ?? '') === 'Lainnya') {
            $validated['pekerjaan_wali'] = $validated['pekerjaan_wali_lainnya'] ?? 'Lainnya';
        }
        unset($validated['pekerjaan_ayah_lainnya'], $validated['pekerjaan_ibu_lainnya'], $validated['pekerjaan_wali_lainnya']);

        if ($alamatSama == 1) {
            $validated['provinsi_ortu'] = $validated['provinsi'] ?? null;
            $validated['kabupaten_ortu'] = $validated['kabupaten'] ?? null;
            $validated['kecamatan_ortu'] = $validated['kecamatan'] ?? null;
            $validated['desa_ortu'] = $validated['desa'] ?? null;
            $validated['alamat_detail_ortu'] = $validated['alamat_detail'] ?? null;
            $validated['rt_ortu'] = $validated['rt'] ?? null;
            $validated['rw_ortu'] = $validated['rw'] ?? null;
            $validated['kode_pos_ortu'] = $validated['kode_pos'] ?? null;
        }

        // Process File Saves
        $fileKeys = ['foto_kk', 'foto_ktp_ortu', 'ijazah_terakhir', 'foto_akte_kelahiran'];
        foreach ($fileKeys as $key) {
            if ($request->hasFile($key)) {
                $validated[$key] = $request->file($key)->store('pendaftaran', 'public');
            } elseif ($request->input('temp_' . $key)) {
                // Determine destination
                $oldPath = $request->input('temp_' . $key);
                $newPath = str_replace('temp_pendaftaran', 'pendaftaran', $oldPath);

                // Move from temp to permanent
                if (\Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->move($oldPath, $newPath);
                    $validated[$key] = $newPath;
                }
            }
        }

        $validated['status'] = 'pending';
        $validated['alamat_ortu_sama'] = $alamatSama;
        // Validasi kode referral — abaikan jika tidak terdaftar di database
        $referralCode = $request->input('referral_code') ?: null;
        if ($referralCode && !\App\Models\ReferralLink::where('code', $referralCode)->exists()) {
            $referralCode = null;
        }
        $validated['referral_code'] = $referralCode;

        $pendaftaranBaru = \App\Models\Pendaftaran::create($validated);

        // Generate PDF
        $pendaftaran = $pendaftaranBaru; // Untuk passing ke view
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.pendaftaran.pdf', compact('pendaftaran'));

        // Simpan PDF sementara
        $pdfFilename = 'pdf_pendaftaran/Bukti_Pendaftaran_' . $pendaftaranBaru->nisn . '_' . time() . '.pdf';
        \Illuminate\Support\Facades\Storage::disk('public')->put($pdfFilename, $pdf->output());

        // Dispatch Job (Background) untuk kirim WA
        \App\Jobs\SendWhatsAppPendaftaranNotification::dispatch($pendaftaranBaru, $pdfFilename);

        return redirect()->route('pendaftaran.sukses');
    }

    public function sukses()
    {
        return view('pendaftaran.sukses');
    }
}

<x-registration-layout>
    <div class="mb-4 text-sm text-gray-600 px-2">
        {{ __('Silahkan isi formulir pendaftaran di bawah ini dengan lengkap dan data yang sebenarnya.') }}
    </div>

    <!-- Validation Errors -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
            <div class="font-semibold text-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Whoops! Ada yang salah.') }}
            </div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('pendaftaran.store') }}" enctype="multipart/form-data" class="space-y-8"
        x-data="{ step: 1 }">
        @csrf
        <input type="hidden" name="referral_code" value="{{ old('referral_code', $referralCode ?? '') }}">

        <!-- Progress Bar Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0 rounded-full">
                </div>
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-blue-500 z-0 rounded-full transition-all duration-500"
                    :style="'width: ' + ((step - 1) / 3 * 100) + '%'"></div>

                <template x-for="i in 4">
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300 border-4"
                            :class="step >= i ? 'bg-blue-600 text-white border-blue-200' : 'bg-white text-gray-400 border-gray-200'">
                            <span x-text="i"></span>
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-between text-xs font-semibold text-gray-500 mt-2 px-1">
                <span :class="step >= 1 ? 'text-blue-600' : ''">Data Siswa</span>
                <span :class="step >= 2 ? 'text-blue-600' : ''">Alamat</span>
                <span :class="step >= 3 ? 'text-blue-600' : ''">Orang Tua</span>
                <span :class="step >= 4 ? 'text-blue-600' : ''">Dokumen</span>
            </div>
        </div>

        <!-- Bagian 1: Data Diri Siswa -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-50/50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <span
                    class="bg-blue-100 text-blue-700 font-bold rounded-full w-8 h-8 flex items-center justify-center">1</span>
                <h3 class="text-lg font-bold text-gray-800">Data Diri Pribadi Siswa</h3>
            </div>
            <div class="p-6">
                <!-- NIK, NISN, KK -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="nik" value="NIK Siswa (16 Digit)" />
                        <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')"
                            required maxlength="16" />
                    </div>
                    <div>
                        <x-input-label for="nisn" value="NISN Siswa" />
                        <x-text-input id="nisn" class="block mt-1 w-full" type="text" name="nisn" :value="old('nisn')"
                            maxlength="15" />
                    </div>
                    <div>
                        <x-input-label for="no_kk" value="No. Kartu Keluarga" />
                        <x-text-input id="no_kk" class="block mt-1 w-full" type="text" name="no_kk"
                            :value="old('no_kk')" required maxlength="16" />
                    </div>
                </div>
                <!-- Row 2: Nama (Full Width) & Nama Panggilan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="md:col-span-2">
                        <x-input-label for="nama" value="Nama Lengkap" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')"
                            required />
                    </div>
                    <div>
                        <x-input-label for="nama_panggilan" value="Nama Panggilan" />
                        <x-text-input id="nama_panggilan" class="block mt-1 w-full" type="text" name="nama_panggilan"
                            :value="old('nama_panggilan')" />
                    </div>
                    <div>
                        <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="agama" value="Agama" />
                        <select id="agama" name="agama"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                        <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir"
                            :value="old('tempat_lahir')" required />
                    </div>
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
                            :value="old('tanggal_lahir')" required />
                    </div>
                    <div>
                        <x-input-label for="no_telp" value="No. Telepon/WA Siswa" />
                        <x-text-input id="no_telp" class="block mt-1 w-full" type="text" name="no_telp"
                            :value="old('no_telp')" required />
                    </div>
                    <div>
                        <x-input-label for="sekolah_asal" value="Sekolah Asal" />
                        <x-text-input id="sekolah_asal" class="block mt-1 w-full" type="text" name="sekolah_asal"
                            :value="old('sekolah_asal')" required />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <x-input-label for="anak_ke" value="Anak Ke" />
                        <x-text-input id="anak_ke" class="block mt-1 w-full" type="number" name="anak_ke"
                            :value="old('anak_ke')" required />
                    </div>
                    <div>
                        <x-input-label for="dari_bersaudara" value="Dari Berapa Saudara" />
                        <x-text-input id="dari_bersaudara" class="block mt-1 w-full" type="number"
                            name="dari_bersaudara" :value="old('dari_bersaudara')" required />
                    </div>
                    <div>
                        <x-input-label for="status_anak" value="Status Anak" />
                        <select id="status_anak" name="status_anak"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            required>
                            <option value="">-- Pilih --</option>
                            <option value="kandung" {{ old('status_anak') == 'kandung' ? 'selected' : '' }}>Kandung
                            </option>
                            <option value="tiri" {{ old('status_anak') == 'tiri' ? 'selected' : '' }}>Tiri</option>
                            <option value="angkat" {{ old('status_anak') == 'angkat' ? 'selected' : '' }}>Angkat</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <x-input-label for="berat_badan" value="Berat Badan (kg)" />
                        <x-text-input id="berat_badan" class="block mt-1 w-full" type="number" name="berat_badan"
                            :value="old('berat_badan')" required />
                    </div>
                    <div>
                        <x-input-label for="tinggi_badan" value="Tinggi Badan (cm)" />
                        <x-text-input id="tinggi_badan" class="block mt-1 w-full" type="number" name="tinggi_badan"
                            :value="old('tinggi_badan')" required />
                    </div>
                </div> <!-- End Grid Section 1 Part 2 -->
            </div> <!-- End Padding Section 1 -->

            <!-- Step 1 Navigation -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
                <button type="button" @click="
                        let isValid = true;
                        let firstInvalid = null;
                        let btn = $el;
                        let originalText = btn.innerHTML;
                        
                        $el.closest('div[x-show]').querySelectorAll('input, select, textarea').forEach(input => {
                            if (!input.checkValidity()) {
                                isValid = false;
                                if (!firstInvalid) firstInvalid = input;
                            }
                        });
                        
                        if (isValid) {
                            step = 2; 
                            window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            if (firstInvalid) {
                                firstInvalid.reportValidity();
                                firstInvalid.focus();
                            }
                        }
                    "
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    Selanjutnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div> <!-- End Card Section 1 -->

        <!-- Bagian 2: Alamat Siswa -->
        <div x-show="step === 2" style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-50/50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <span
                    class="bg-blue-100 text-blue-700 font-bold rounded-full w-8 h-8 flex items-center justify-center">2</span>
                <h3 class="text-lg font-bold text-gray-800">Alamat Lengkap Siswa</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <x-input-label for="provinsi" value="Provinsi" />
                        <select id="provinsi" name="provinsi"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            required>
                            <option value="">-- Pilih Provinsi --</option>
                        </select>
                        <!-- hidden field to store text -->
                        <input type="hidden" name="provinsi" id="provinsi_text" value="{{ old('provinsi') }}">
                    </div>
                    <div>
                        <x-input-label for="kabupaten" value="Kabupaten/Kota" />
                        <select id="kabupaten" name="kabupaten"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm disabled:bg-gray-100"
                            required disabled>
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                        </select>
                        <input type="hidden" name="kabupaten" id="kabupaten_text" value="{{ old('kabupaten') }}">
                    </div>
                    <div>
                        <x-input-label for="kecamatan" value="Kecamatan" />
                        <select id="kecamatan" name="kecamatan"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm disabled:bg-gray-100"
                            required disabled>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                        <input type="hidden" name="kecamatan" id="kecamatan_text" value="{{ old('kecamatan') }}">
                    </div>
                    <div>
                        <x-input-label for="desa" value="Desa/Kelurahan" />
                        <select id="desa" name="desa"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm disabled:bg-gray-100"
                            required disabled>
                            <option value="">-- Pilih Desa/Kelurahan --</option>
                        </select>
                        <input type="hidden" name="desa" id="desa_text" value="{{ old('desa') }}">
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="alamat_detail" value="Detail Alamat (Jalan, Nomor, dsb)" />
                        <textarea id="alamat_detail" name="alamat_detail"
                            class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                            rows="3" required>{{ old('alamat_detail') }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="rt" value="RT" />
                        <x-text-input id="rt" class="block mt-1 w-full" type="text" name="rt" :value="old('rt')"
                            maxlength="5" />
                    </div>
                    <div>
                        <x-input-label for="rw" value="RW" />
                        <x-text-input id="rw" class="block mt-1 w-full" type="text" name="rw" :value="old('rw')"
                            maxlength="5" />
                    </div>
                    <div>
                        <x-input-label for="kode_pos" value="Kode Pos" />
                        <x-text-input id="kode_pos" class="block mt-1 w-full bg-gray-50" type="text" name="kode_pos"
                            :value="old('kode_pos')" maxlength="10" />
                    </div>
                </div>
            </div> <!-- End Padding Section 2 -->

            <!-- Step 2 Navigation -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between">
                <button type="button" @click="step = 1; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="bg-white border border-gray-300 hover:bg-gray-100 font-bold py-2 px-6 rounded-lg shadow-sm transition-colors text-gray-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Sebelumnya
                </button>
                <button type="button" @click="
                        let isValid = true;
                        let firstInvalid = null;
                        $el.closest('div[x-show]').querySelectorAll('input, select, textarea').forEach(input => {
                            if (!input.checkValidity()) {
                                isValid = false;
                                if (!firstInvalid) firstInvalid = input;
                            }
                        });
                        if (isValid) {
                            step = 3; window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            if (firstInvalid) firstInvalid.reportValidity();
                        }
                    "
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    Selanjutnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div> <!-- End Card Section 2 -->

        <!-- Bagian 3: Data Orang Tua -->
        <div x-show="step === 3" style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-50/50 px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <span
                    class="bg-blue-100 text-blue-700 font-bold rounded-full w-8 h-8 flex items-center justify-center">3</span>
                <h3 class="text-lg font-bold text-gray-800">Data Orang Tua / Wali</h3>
            </div>
            <div class="p-6" x-data="{ 
                statusAyah: '{{ old('status_ayah', 'masih_hidup') }}', 
                statusIbu: '{{ old('status_ibu', 'masih_hidup') }}',
                pekerjaanAyah: '{{ old('pekerjaan_ayah') }}',
                pekerjaanIbu: '{{ old('pekerjaan_ibu') }}',
                pekerjaanWali: '{{ old('pekerjaan_wali') }}'
            }">

                <div class="grid grid-cols-1 gap-8">
                    <!-- Data Ayah -->
                    <div class="bg-gray-50/80 p-5 rounded-xl border border-gray-200">
                        <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Data Ayah
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="status_ayah" value="Status Ayah" />
                                <select id="status_ayah" name="status_ayah"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    required x-model="statusAyah">
                                    <option value="masih_hidup" {{ old('status_ayah', 'masih_hidup') == 'masih_hidup' ? 'selected' : '' }}>Masih Hidup</option>
                                    <option value="sudah_meninggal" {{ old('status_ayah') == 'sudah_meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="nama_ayah" value="Nama Ayah" />
                                <x-text-input id="nama_ayah" class="block mt-1 w-full" type="text" name="nama_ayah"
                                    :value="old('nama_ayah')" required />
                            </div>
                            <div class="ayah_detail">
                                <x-input-label for="no_telp_ayah" value="No. HP Ayah" />
                                <x-text-input id="no_telp_ayah" class="block mt-1 w-full" type="text"
                                    name="no_telp_ayah" :value="old('no_telp_ayah')" />
                            </div>
                        </div>
                        <div class="ayah_detail grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="pendidikan_ayah" value="Pendidikan Terakhir" />
                                <select id="pendidikan_ayah" name="pendidikan_ayah"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-bind:required="statusAyah === 'masih_hidup'">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="Tidak/Belum Sekolah" {{ old('pendidikan_ayah') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                                    <option value="SD/Sederajat" {{ old('pendidikan_ayah') == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                                    <option value="SMP/Sederajat" {{ old('pendidikan_ayah') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                                    <option value="SMA/SMK/Sederajat" {{ old('pendidikan_ayah') == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                                    <option value="D1/D2/D3" {{ old('pendidikan_ayah') == 'D1/D2/D3' ? 'selected' : '' }}>
                                        D1/D2/D3</option>
                                    <option value="D4/S1" {{ old('pendidikan_ayah') == 'D4/S1' ? 'selected' : '' }}>D4/S1
                                    </option>
                                    <option value="S2/S3" {{ old('pendidikan_ayah') == 'S2/S3' ? 'selected' : '' }}>S2/S3
                                    </option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="pekerjaan_ayah" value="Pekerjaan Utama" />
                                <select id="pekerjaan_ayah" name="pekerjaan_ayah"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-model="pekerjaanAyah" x-bind:required="statusAyah === 'masih_hidup'">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="Tidak Bekerja / Ibu Rumah Tangga" {{ old('pekerjaan_ayah') == 'Tidak Bekerja / Ibu Rumah Tangga' ? 'selected' : '' }}>Tidak Bekerja / Ibu Rumah
                                        Tangga</option>
                                    <option value="Petani / Pekebun" {{ old('pekerjaan_ayah') == 'Petani / Pekebun' ? 'selected' : '' }}>Petani / Pekebun</option>
                                    <option value="Nelayan" {{ old('pekerjaan_ayah') == 'Nelayan' ? 'selected' : '' }}>
                                        Nelayan</option>
                                    <option value="Buruh" {{ old('pekerjaan_ayah') == 'Buruh' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="Pedagang" {{ old('pekerjaan_ayah') == 'Pedagang' ? 'selected' : '' }}>
                                        Pedagang</option>
                                    <option value="Wiraswasta / Wirausaha" {{ old('pekerjaan_ayah') == 'Wiraswasta / Wirausaha' ? 'selected' : '' }}>Wiraswasta / Wirausaha</option>
                                    <option value="Karyawan Swasta" {{ old('pekerjaan_ayah') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="PNS / ASN" {{ old('pekerjaan_ayah') == 'PNS / ASN' ? 'selected' : '' }}>PNS / ASN</option>
                                    <option value="TNI / Polri" {{ old('pekerjaan_ayah') == 'TNI / Polri' ? 'selected' : '' }}>TNI / Polri</option>
                                    <option value="Guru / Dosen" {{ old('pekerjaan_ayah') == 'Guru / Dosen' ? 'selected' : '' }}>Guru / Dosen</option>
                                    <option value="Tenaga Kesehatan (Dokter / Perawat / Bidan)" {{ old('pekerjaan_ayah') == 'Tenaga Kesehatan (Dokter / Perawat / Bidan)' ? 'selected' : '' }}>Tenaga Kesehatan (Dokter / Perawat / Bidan)</option>
                                    <option value="Sopir / Ojek / Transportasi" {{ old('pekerjaan_ayah') == 'Sopir / Ojek / Transportasi' ? 'selected' : '' }}>Sopir / Ojek / Transportasi</option>
                                    <option value="Pensiunan" {{ old('pekerjaan_ayah') == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Pekerja Migran (TKI / TKW)" {{ old('pekerjaan_ayah') == 'Pekerja Migran (TKI / TKW)' ? 'selected' : '' }}>Pekerja Migran (TKI / TKW)</option>
                                    <option value="Lainnya" {{ old('pekerjaan_ayah') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                <div x-show="pekerjaanAyah === 'Lainnya'" class="mt-2 text-sm" style="display: none;">
                                    <x-text-input id="pekerjaan_ayah_lainnya" class="block w-full" type="text"
                                        name="pekerjaan_ayah_lainnya" :value="old('pekerjaan_ayah_lainnya')"
                                        placeholder="Sebutkan Pekerjaan..." />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="penghasilan_ayah" value="Penghasilan / Bulan" />
                                <select id="penghasilan_ayah" name="penghasilan_ayah"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-bind:required="statusAyah === 'masih_hidup'">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    <option value="Tidak Berpenghasilan" {{ old('penghasilan_ayah') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                                    <option value="Kurang dari Rp500.000" {{ old('penghasilan_ayah') == 'Kurang dari Rp500.000' ? 'selected' : '' }}>Kurang dari Rp500.000</option>
                                    <option value="Rp500.000 – Rp999.999" {{ old('penghasilan_ayah') == 'Rp500.000 – Rp999.999' ? 'selected' : '' }}>Rp500.000 – Rp999.999</option>
                                    <option value="Rp1.000.000 – Rp1.999.999" {{ old('penghasilan_ayah') == 'Rp1.000.000 – Rp1.999.999' ? 'selected' : '' }}>Rp1.000.000 – Rp1.999.999</option>
                                    <option value="Rp2.000.000 – Rp4.999.999" {{ old('penghasilan_ayah') == 'Rp2.000.000 – Rp4.999.999' ? 'selected' : '' }}>Rp2.000.000 – Rp4.999.999</option>
                                    <option value="Rp5.000.000 – Rp20.000.000" {{ old('penghasilan_ayah') == 'Rp5.000.000 – Rp20.000.000' ? 'selected' : '' }}>Rp5.000.000 – Rp20.000.000</option>
                                    <option value="Lebih dari Rp20.000.000" {{ old('penghasilan_ayah') == 'Lebih dari Rp20.000.000' ? 'selected' : '' }}>Lebih dari Rp20.000.000</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Data Ibu -->
                    <div class="bg-gray-50/80 p-5 rounded-xl border border-gray-200">
                        <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            Data Ibu
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="status_ibu" value="Status Ibu" />
                                <select id="status_ibu" name="status_ibu"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    required x-model="statusIbu">
                                    <option value="masih_hidup" {{ old('status_ibu', 'masih_hidup') == 'masih_hidup' ? 'selected' : '' }}>Masih Hidup</option>
                                    <option value="sudah_meninggal" {{ old('status_ibu') == 'sudah_meninggal' ? 'selected' : '' }}>Sudah Meninggal</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="nama_ibu" value="Nama Ibu" />
                                <x-text-input id="nama_ibu" class="block mt-1 w-full" type="text" name="nama_ibu"
                                    :value="old('nama_ibu')" required />
                            </div>
                            <div class="ibu_detail">
                                <x-input-label for="no_telp_ibu" value="No. HP Ibu" />
                                <x-text-input id="no_telp_ibu" class="block mt-1 w-full" type="text" name="no_telp_ibu"
                                    :value="old('no_telp_ibu')" />
                            </div>
                        </div>
                        <div class="ibu_detail grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                            <div>
                                <x-input-label for="pendidikan_ibu" value="Pendidikan Terakhir" />
                                <select id="pendidikan_ibu" name="pendidikan_ibu"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-bind:required="statusIbu === 'masih_hidup'">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="Tidak/Belum Sekolah" {{ old('pendidikan_ibu') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                                    <option value="SD/Sederajat" {{ old('pendidikan_ibu') == 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                                    <option value="SMP/Sederajat" {{ old('pendidikan_ibu') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                                    <option value="SMA/SMK/Sederajat" {{ old('pendidikan_ibu') == 'SMA/SMK/Sederajat' ? 'selected' : '' }}>SMA/SMK/Sederajat</option>
                                    <option value="D1/D2/D3" {{ old('pendidikan_ibu') == 'D1/D2/D3' ? 'selected' : '' }}>
                                        D1/D2/D3</option>
                                    <option value="D4/S1" {{ old('pendidikan_ibu') == 'D4/S1' ? 'selected' : '' }}>D4/S1
                                    </option>
                                    <option value="S2/S3" {{ old('pendidikan_ibu') == 'S2/S3' ? 'selected' : '' }}>S2/S3
                                    </option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="pekerjaan_ibu" value="Pekerjaan Utama" />
                                <select id="pekerjaan_ibu" name="pekerjaan_ibu"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-model="pekerjaanIbu" x-bind:required="statusIbu === 'masih_hidup'">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="Tidak Bekerja / Ibu Rumah Tangga" {{ old('pekerjaan_ibu') == 'Tidak Bekerja / Ibu Rumah Tangga' ? 'selected' : '' }}>Tidak Bekerja / Ibu Rumah
                                        Tangga</option>
                                    <option value="Petani / Pekebun" {{ old('pekerjaan_ibu') == 'Petani / Pekebun' ? 'selected' : '' }}>Petani / Pekebun</option>
                                    <option value="Nelayan" {{ old('pekerjaan_ibu') == 'Nelayan' ? 'selected' : '' }}>
                                        Nelayan</option>
                                    <option value="Buruh" {{ old('pekerjaan_ibu') == 'Buruh' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="Pedagang" {{ old('pekerjaan_ibu') == 'Pedagang' ? 'selected' : '' }}>
                                        Pedagang</option>
                                    <option value="Wiraswasta / Wirausaha" {{ old('pekerjaan_ibu') == 'Wiraswasta / Wirausaha' ? 'selected' : '' }}>Wiraswasta / Wirausaha</option>
                                    <option value="Karyawan Swasta" {{ old('pekerjaan_ibu') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="PNS / ASN" {{ old('pekerjaan_ibu') == 'PNS / ASN' ? 'selected' : '' }}>
                                        PNS / ASN</option>
                                    <option value="TNI / Polri" {{ old('pekerjaan_ibu') == 'TNI / Polri' ? 'selected' : '' }}>TNI / Polri</option>
                                    <option value="Guru / Dosen" {{ old('pekerjaan_ibu') == 'Guru / Dosen' ? 'selected' : '' }}>Guru / Dosen</option>
                                    <option value="Tenaga Kesehatan (Dokter / Perawat / Bidan)" {{ old('pekerjaan_ibu') == 'Tenaga Kesehatan (Dokter / Perawat / Bidan)' ? 'selected' : '' }}>Tenaga Kesehatan (Dokter / Perawat / Bidan)</option>
                                    <option value="Sopir / Ojek / Transportasi" {{ old('pekerjaan_ibu') == 'Sopir / Ojek / Transportasi' ? 'selected' : '' }}>Sopir / Ojek / Transportasi</option>
                                    <option value="Pensiunan" {{ old('pekerjaan_ibu') == 'Pensiunan' ? 'selected' : '' }}>
                                        Pensiunan</option>
                                    <option value="Pekerja Migran (TKI / TKW)" {{ old('pekerjaan_ibu') == 'Pekerja Migran (TKI / TKW)' ? 'selected' : '' }}>Pekerja Migran (TKI / TKW)</option>
                                    <option value="Lainnya" {{ old('pekerjaan_ibu') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                <div x-show="pekerjaanIbu === 'Lainnya'" class="mt-2 text-sm" style="display: none;">
                                    <x-text-input id="pekerjaan_ibu_lainnya" class="block w-full" type="text"
                                        name="pekerjaan_ibu_lainnya" :value="old('pekerjaan_ibu_lainnya')"
                                        placeholder="Sebutkan Pekerjaan..." />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="penghasilan_ibu" value="Penghasilan / Bulan" />
                                <select id="penghasilan_ibu" name="penghasilan_ibu"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-bind:required="statusIbu === 'masih_hidup'">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    <option value="Tidak Berpenghasilan" {{ old('penghasilan_ibu') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                                    <option value="Kurang dari Rp500.000" {{ old('penghasilan_ibu') == 'Kurang dari Rp500.000' ? 'selected' : '' }}>Kurang dari Rp500.000</option>
                                    <option value="Rp500.000 – Rp999.999" {{ old('penghasilan_ibu') == 'Rp500.000 – Rp999.999' ? 'selected' : '' }}>Rp500.000 – Rp999.999</option>
                                    <option value="Rp1.000.000 – Rp1.999.999" {{ old('penghasilan_ibu') == 'Rp1.000.000 – Rp1.999.999' ? 'selected' : '' }}>Rp1.000.000 – Rp1.999.999</option>
                                    <option value="Rp2.000.000 – Rp4.999.999" {{ old('penghasilan_ibu') == 'Rp2.000.000 – Rp4.999.999' ? 'selected' : '' }}>Rp2.000.000 – Rp4.999.999</option>
                                    <option value="Rp5.000.000 – Rp20.000.000" {{ old('penghasilan_ibu') == 'Rp5.000.000 – Rp20.000.000' ? 'selected' : '' }}>Rp5.000.000 – Rp20.000.000</option>
                                    <option value="Lebih dari Rp20.000.000" {{ old('penghasilan_ibu') == 'Lebih dari Rp20.000.000' ? 'selected' : '' }}>Lebih dari Rp20.000.000</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Data Wali -->
                    <div id="data_wali_container" class="bg-blue-50 p-4 rounded-md border" style="display: none;">
                        <h4 class="font-medium text-blue-800 mb-2">Data Wali (Wajib diisi jika kedua orang tua telah
                            meninggal)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nama_wali" value="Nama Wali" />
                                <x-text-input id="nama_wali" class="block mt-1 w-full" type="text" name="nama_wali"
                                    :value="old('nama_wali')" />
                            </div>
                            <div>
                                <x-input-label for="no_telp_wali" value="Nomor Telepon Wali" />
                                <x-text-input id="no_telp_wali" class="block mt-1 w-full" type="text"
                                    name="no_telp_wali" :value="old('no_telp_wali')" />
                            </div>
                            <div>
                                <x-input-label for="pendidikan_wali" value="Pendidikan Wali" />
                                <select id="pendidikan_wali" name="pendidikan_wali"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="SD/Sederajat" {{ old('pendidikan_wali') == 'SD/Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                                    <option value="SMP/Sederajat" {{ old('pendidikan_wali') == 'SMP/Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                                    <option value="SMA/Sederajat" {{ old('pendidikan_wali') == 'SMA/Sederajat' ? 'selected' : '' }}>SMA / Sederajat</option>
                                    <option value="D1-D3" {{ old('pendidikan_wali') == 'D1-D3' ? 'selected' : '' }}>D1 -
                                        D3</option>
                                    <option value="S1/D4" {{ old('pendidikan_wali') == 'S1/D4' ? 'selected' : '' }}>S1 /
                                        D4</option>
                                    <option value="S2" {{ old('pendidikan_wali') == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ old('pendidikan_wali') == 'S3' ? 'selected' : '' }}>S3</option>
                                    <option value="Tidak Sekolah" {{ old('pendidikan_wali') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="pekerjaan_wali" value="Pekerjaan Wali" />
                                <select id="pekerjaan_wali" name="pekerjaan_wali"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                    x-model="pekerjaanWali">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    <option value="Tidak Bekerja / Ibu Rumah Tangga" {{ old('pekerjaan_wali') == 'Tidak Bekerja / Ibu Rumah Tangga' ? 'selected' : '' }}>Tidak Bekerja / Ibu Rumah
                                        Tangga</option>
                                    <option value="Petani / Pekebun" {{ old('pekerjaan_wali') == 'Petani / Pekebun' ? 'selected' : '' }}>Petani / Pekebun</option>
                                    <option value="Nelayan" {{ old('pekerjaan_wali') == 'Nelayan' ? 'selected' : '' }}>
                                        Nelayan</option>
                                    <option value="Buruh" {{ old('pekerjaan_wali') == 'Buruh' ? 'selected' : '' }}>Buruh
                                    </option>
                                    <option value="Pedagang" {{ old('pekerjaan_wali') == 'Pedagang' ? 'selected' : '' }}>
                                        Pedagang</option>
                                    <option value="Wiraswasta / Wirausaha" {{ old('pekerjaan_wali') == 'Wiraswasta / Wirausaha' ? 'selected' : '' }}>Wiraswasta / Wirausaha</option>
                                    <option value="Karyawan Swasta" {{ old('pekerjaan_wali') == 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                                    <option value="PNS / ASN" {{ old('pekerjaan_wali') == 'PNS / ASN' ? 'selected' : '' }}>PNS / ASN</option>
                                    <option value="TNI / Polri" {{ old('pekerjaan_wali') == 'TNI / Polri' ? 'selected' : '' }}>TNI / Polri</option>
                                    <option value="Guru / Dosen" {{ old('pekerjaan_wali') == 'Guru / Dosen' ? 'selected' : '' }}>Guru / Dosen</option>
                                    <option value="Tenaga Kesehatan (Dokter / Perawat / Bidan)" {{ old('pekerjaan_wali') == 'Tenaga Kesehatan (Dokter / Perawat / Bidan)' ? 'selected' : '' }}>Tenaga Kesehatan (Dokter / Perawat / Bidan)</option>
                                    <option value="Sopir / Ojek / Transportasi" {{ old('pekerjaan_wali') == 'Sopir / Ojek / Transportasi' ? 'selected' : '' }}>Sopir / Ojek / Transportasi</option>
                                    <option value="Pensiunan" {{ old('pekerjaan_wali') == 'Pensiunan' ? 'selected' : '' }}>Pensiunan</option>
                                    <option value="Pekerja Migran (TKI / TKW)" {{ old('pekerjaan_wali') == 'Pekerja Migran (TKI / TKW)' ? 'selected' : '' }}>Pekerja Migran (TKI / TKW)</option>
                                    <option value="Lainnya" {{ old('pekerjaan_wali') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
                                <div x-show="pekerjaanWali === 'Lainnya'" class="mt-2 text-sm" style="display: none;">
                                    <x-text-input id="pekerjaan_wali_lainnya" class="block w-full" type="text"
                                        name="pekerjaan_wali_lainnya" :value="old('pekerjaan_wali_lainnya')"
                                        placeholder="Sebutkan Pekerjaan..." />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="penghasilan_wali" value="Penghasilan / Bulan" />
                                <select id="penghasilan_wali" name="penghasilan_wali"
                                    class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">-- Pilih Penghasilan --</option>
                                    <option value="Tidak Berpenghasilan" {{ old('penghasilan_wali') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan</option>
                                    <option value="Kurang dari Rp500.000" {{ old('penghasilan_wali') == 'Kurang dari Rp500.000' ? 'selected' : '' }}>Kurang dari Rp500.000</option>
                                    <option value="Rp500.000 – Rp999.999" {{ old('penghasilan_wali') == 'Rp500.000 – Rp999.999' ? 'selected' : '' }}>Rp500.000 – Rp999.999</option>
                                    <option value="Rp1.000.000 – Rp1.999.999" {{ old('penghasilan_wali') == 'Rp1.000.000 – Rp1.999.999' ? 'selected' : '' }}>Rp1.000.000 – Rp1.999.999</option>
                                    <option value="Rp2.000.000 – Rp4.999.999" {{ old('penghasilan_wali') == 'Rp2.000.000 – Rp4.999.999' ? 'selected' : '' }}>Rp2.000.000 – Rp4.999.999</option>
                                    <option value="Rp5.000.000 – Rp20.000.000" {{ old('penghasilan_wali') == 'Rp5.000.000 – Rp20.000.000' ? 'selected' : '' }}>Rp5.000.000 – Rp20.000.000</option>
                                    <option value="Lebih dari Rp20.000.000" {{ old('penghasilan_wali') == 'Lebih dari Rp20.000.000' ? 'selected' : '' }}>Lebih dari Rp20.000.000</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- End Data Wali Container -->
                </div> <!-- End xl:grid-cols-2 -->

                <!-- Bagian 3 Lanjutan: Alamat Orang Tua/Wali -->
                <div class="mt-8 pt-8 border-t border-gray-100">
                    <h4 class="font-bold text-gray-800 flex items-center gap-2 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                        Alamat Orang Tua / Wali
                    </h4>

                    <div class="mb-6 flex items-center bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                        <input type="hidden" name="alamat_ortu_sama" value="0"> <!-- Fallback if unchecked -->
                        <input id="alamat_ortu_sama" type="checkbox" name="alamat_ortu_sama" value="1"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 w-5 h-5 mr-3" {{ old('alamat_ortu_sama', '1') == '1' ? 'checked' : '' }}>
                        <label for="alamat_ortu_sama" class="text-sm font-medium text-gray-700">Centang jika <span
                                class="text-blue-600 font-bold">Alamat Orang Tua / Wali sama</span> dengan alamat Anak
                            (Siswa)</label>
                    </div>

                    <div id="alamat_ortu_container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                        style="position: relative;">
                        <!-- Overlay to visually indicate disabled state -->
                        <div id="alamat_ortu_overlay"
                            style="display: none; position: absolute; top:-10px; left:-10px; right:-10px; bottom:-10px; background: rgba(249, 250, 251, 0.5); z-index: 5; pointer-events: none; border-radius: 0.5rem;">
                        </div>
                        <div>
                            <x-input-label for="provinsi_ortu_select" value="Provinsi" />
                            <select id="provinsi_ortu_select"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                            <input type="hidden" name="provinsi_ortu" id="provinsi_ortu_text"
                                value="{{ old('provinsi_ortu') }}">
                        </div>
                        <div>
                            <x-input-label for="kabupaten_ortu_select" value="Kabupaten/Kota" />
                            <select id="kabupaten_ortu_select"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm disabled:bg-gray-100"
                                disabled>
                                <option value="">-- Pilih Kabupaten/Kota --</option>
                            </select>
                            <input type="hidden" name="kabupaten_ortu" id="kabupaten_ortu_text"
                                value="{{ old('kabupaten_ortu') }}">
                        </div>
                        <div>
                            <x-input-label for="kecamatan_ortu_select" value="Kecamatan" />
                            <select id="kecamatan_ortu_select"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm disabled:bg-gray-100"
                                disabled>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                            <input type="hidden" name="kecamatan_ortu" id="kecamatan_ortu_text"
                                value="{{ old('kecamatan_ortu') }}">
                        </div>
                        <div>
                            <x-input-label for="desa_ortu_select" value="Desa/Kelurahan" />
                            <select id="desa_ortu_select"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm disabled:bg-gray-100"
                                disabled>
                                <option value="">-- Pilih Desa/Kelurahan --</option>
                            </select>
                            <input type="hidden" name="desa_ortu" id="desa_ortu_text" value="{{ old('desa_ortu') }}">
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="alamat_detail_ortu" value="Detail Alamat (Jalan, Nomor, dsb)" />
                            <textarea id="alamat_detail_ortu" name="alamat_detail_ortu"
                                class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                                rows="3">{{ old('alamat_detail_ortu') }}</textarea>
                        </div>
                        <div>
                            <x-input-label for="rt_ortu" value="RT Ortu" />
                            <x-text-input id="rt_ortu" class="block mt-1 w-full" type="text" name="rt_ortu"
                                :value="old('rt_ortu')" maxlength="5" />
                        </div>
                        <div>
                            <x-input-label for="rw_ortu" value="RW Ortu" />
                            <x-text-input id="rw_ortu" class="block mt-1 w-full" type="text" name="rw_ortu"
                                :value="old('rw_ortu')" maxlength="5" />
                        </div>
                        <div>
                            <x-input-label for="kode_pos_ortu" value="Kode Pos Ortu" />
                            <x-text-input id="kode_pos_ortu" class="block mt-1 w-full bg-gray-50" type="text"
                                name="kode_pos_ortu" :value="old('kode_pos_ortu')" maxlength="10" />
                            <p class="text-xs text-gray-500 mt-1">Terisi otomatis berdasarkan Desa/Kecamatan</p>
                        </div>
                    </div> <!-- End Alamat Ortu Grid -->
                </div>
            </div> <!-- End Padding Section 3 -->

            <!-- Step 3 Navigation -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between">
                <button type="button" @click="step = 2; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="bg-white border border-gray-300 hover:bg-gray-100 font-bold py-2 px-6 rounded-lg shadow-sm transition-colors text-gray-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Sebelumnya
                </button>
                <button type="button" @click="
                        let isValid = true;
                        let firstInvalid = null;
                        $el.closest('div[x-show]').querySelectorAll('input:not([disabled]), select:not([disabled]), textarea:not([disabled])').forEach(input => {
                            if (!input.checkValidity()) {
                                isValid = false;
                                if (!firstInvalid) firstInvalid = input;
                            }
                        });
                        if (isValid) {
                            step = 4; window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            if (firstInvalid) firstInvalid.reportValidity();
                        }
                    "
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition-colors flex items-center gap-2">
                    Selanjutnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div> <!-- End Card Section 3 -->

        <!-- Bagian 4: Upload Dokumen -->
        <div x-show="step === 4" x-cloak style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0"
            class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-50/50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span
                        class="bg-blue-100 text-blue-700 font-bold rounded-full w-8 h-8 flex items-center justify-center">4</span>
                    <h3 class="text-lg font-bold text-gray-800">Upload Dokumen Persyaratan</h3>
                </div>
                <p class="text-xs font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Max 2MB per file
                    (JPG/PNG)</p>
            </div>
            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                    <!-- Kartu Keluarga -->
                    <div
                        class="bg-gray-50 border border-gray-200 border-dashed rounded-xl p-6 text-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <x-input-label for="foto_kk" value="Kartu Keluarga (Wajib)" class="font-bold text-gray-700" />
                        @if(old('temp_foto_kk'))
                            <input type="hidden" name="temp_foto_kk" value="{{ old('temp_foto_kk') }}">
                            <input type="hidden" name="temp_foto_kk_name" value="{{ old('temp_foto_kk_name') }}">
                            <span class="text-green-600 text-xs mt-2 block font-semibold">✔
                                {{ old('temp_foto_kk_name', 'File') }} sudah diunggah.</span>
                            <div class="relative mt-2" x-data="{ fileName: 'Ganti file (opsional)' }">
                                <input type="file" id="foto_kk" name="foto_kk"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'Ganti file (opsional)'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-gray-200 text-gray-700 text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-gray-300 transition">Choose
                                        File</span>
                                </div>
                            </div>
                        @else
                            <div class="relative mt-3" x-data="{ fileName: 'No file chosen' }">
                                <input type="file" id="foto_kk" name="foto_kk"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required
                                    accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'No file chosen'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-blue-600 text-white text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-blue-700 transition shadow-sm">Choose
                                        File</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- KTP Ortu -->
                    <div id="ktp_ortu_container"
                        class="bg-gray-50 border border-gray-200 border-dashed rounded-xl p-6 text-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <x-input-label for="foto_ktp_ortu" value="KTP Orang Tua/Wali(Wajib)"
                            class="font-bold text-gray-700" />
                        @if(old('temp_foto_ktp_ortu'))
                            <input type="hidden" name="temp_foto_ktp_ortu" value="{{ old('temp_foto_ktp_ortu') }}">
                            <input type="hidden" name="temp_foto_ktp_ortu_name"
                                value="{{ old('temp_foto_ktp_ortu_name') }}">
                            <span class="text-green-600 text-xs mt-2 block font-semibold">✔
                                {{ old('temp_foto_ktp_ortu_name', 'File') }} sudah diunggah. </span>
                            <div class="relative mt-2" x-data="{ fileName: 'Ganti file (opsional)' }">
                                <input type="file" id="foto_ktp_ortu" name="foto_ktp_ortu"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'Ganti file (opsional)'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-gray-200 text-gray-700 text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-gray-300 transition">Choose
                                        File</span>
                                </div>
                            </div>
                        @else
                            <div class="relative mt-3" x-data="{ fileName: 'No file chosen' }">
                                <input type="file" id="foto_ktp_ortu" name="foto_ktp_ortu"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'No file chosen'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-blue-600 text-white text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-blue-700 transition shadow-sm">Choose
                                        File</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Akte Kelahiran -->
                    <div
                        class="bg-gray-50 border border-gray-200 border-dashed rounded-xl p-6 text-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <x-input-label for="foto_akte_kelahiran" value="Akte Kelahiran (Wajib)"
                            class="font-bold text-gray-700" />
                        @if(old('temp_foto_akte_kelahiran'))
                            <input type="hidden" name="temp_foto_akte_kelahiran"
                                value="{{ old('temp_foto_akte_kelahiran') }}">
                            <input type="hidden" name="temp_foto_akte_kelahiran_name"
                                value="{{ old('temp_foto_akte_kelahiran_name') }}">
                            <span class="text-green-600 text-xs mt-2 block font-semibold">✔
                                {{ old('temp_foto_akte_kelahiran_name', 'File') }} sudah diunggah. </span>
                            <div class="relative mt-2" x-data="{ fileName: 'Ganti file (opsional)' }">
                                <input type="file" id="foto_akte_kelahiran" name="foto_akte_kelahiran"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'Ganti file (opsional)'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-gray-200 text-gray-700 text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-gray-300 transition">Choose
                                        File</span>
                                </div>
                            </div>
                        @else
                            <div class="relative mt-3" x-data="{ fileName: 'No file chosen' }">
                                <input type="file" id="foto_akte_kelahiran" name="foto_akte_kelahiran"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required
                                    accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'No file chosen'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-blue-600 text-white text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-blue-700 transition shadow-sm">Choose
                                        File</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Ijazah / SKL -->
                    <div
                        class="bg-gray-50 border border-gray-200 border-dashed rounded-xl p-6 text-center hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-gray-400 mb-3" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <x-input-label for="ijazah_terakhir" value="Ijazah Terakhir / SKL (Wajib)"
                            class="font-bold text-gray-700" />
                        @if(old('temp_ijazah_terakhir'))
                            <input type="hidden" name="temp_ijazah_terakhir" value="{{ old('temp_ijazah_terakhir') }}">
                            <input type="hidden" name="temp_ijazah_terakhir_name"
                                value="{{ old('temp_ijazah_terakhir_name') }}">
                            <span class="text-green-600 text-xs mt-2 block font-semibold">✔
                                {{ old('temp_ijazah_terakhir_name', 'File') }} sudah diunggah. </span>
                            <div class="relative mt-2" x-data="{ fileName: 'Ganti file (opsional)' }">
                                <input type="file" id="ijazah_terakhir" name="ijazah_terakhir"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'Ganti file (opsional)'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-gray-200 text-gray-700 text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-gray-300 transition">Choose
                                        File</span>
                                </div>
                            </div>
                        @else
                            <div class="relative mt-3" x-data="{ fileName: 'No file chosen' }">
                                <input type="file" id="ijazah_terakhir" name="ijazah_terakhir"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required
                                    accept="image/*"
                                    @change="fileName = $event.target.files[0]?.name || 'No file chosen'" />
                                <div class="flex flex-col items-center justify-center relative z-0">
                                    <span class="text-xs text-gray-500 mb-2 font-medium truncate w-full px-2"
                                        x-text="fileName"></span>
                                    <span
                                        class="bg-blue-600 text-white text-xs font-semibold py-2 px-5 rounded-full inline-block hover:bg-blue-700 transition shadow-sm">Choose
                                        File</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div> <!-- End Padding Section 5 -->

            <!-- Step 4 Navigation & Submit -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                <button type="button" @click="step = 3; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="bg-white border border-gray-300 hover:bg-gray-100 font-bold py-2 px-6 rounded-lg shadow-sm transition-colors text-gray-700 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Sebelumnya
                </button>
                <button type="submit"
                    class="bg-gradient-to-r from-blue-600 to-blue-600 hover:from-blue-700 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transform transition hover:-translate-y-0.5 text-base flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Kirim Pendaftaran
                </button>
            </div>
        </div> <!-- End Card Section 5 -->
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- 1. Parent Lifecycle & Guardian Logic ---
            const statusAyah = document.getElementById('status_ayah');
            const statusIbu = document.getElementById('status_ibu');
            const ayahDetailElements = document.querySelectorAll('.ayah_detail');
            const ibuDetailElements = document.querySelectorAll('.ibu_detail');
            const waliContainer = document.getElementById('data_wali_container');
            const ktpOrtuContainer = document.getElementById('ktp_ortu_container');
            const ktpOrtuInput = document.getElementById('foto_ktp_ortu');
            const pedidikanAyahInput = document.getElementById('pendidikan_ayah');
            const pekerjaanAyahInput = document.getElementById('pekerjaan_ayah');
            const pedidikanIbuInput = document.getElementById('pendidikan_ibu');
            const pekerjaanIbuInput = document.getElementById('pekerjaan_ibu');

            function updateParentLogic() {
                const ayahMeninggal = statusAyah.value === 'sudah_meninggal';
                const ibuMeninggal = statusIbu.value === 'sudah_meninggal';

                // Show/hide Ayah detail
                ayahDetailElements.forEach(el => el.style.display = ayahMeninggal ? 'none' : 'block');
                if (ayahMeninggal) { pedidikanAyahInput.value = ''; pekerjaanAyahInput.value = ''; }

                // Show/hide Ibu detail
                ibuDetailElements.forEach(el => el.style.display = ibuMeninggal ? 'none' : 'block');
                if (ibuMeninggal) { pedidikanIbuInput.value = ''; pekerjaanIbuInput.value = ''; }

                // Wali logic
                if (ayahMeninggal && ibuMeninggal) {
                    waliContainer.style.display = 'block';
                    ktpOrtuContainer.style.display = 'none';
                    ktpOrtuInput.removeAttribute('required');
                } else {
                    waliContainer.style.display = 'none';
                    ktpOrtuContainer.style.display = 'block';
                    // Only require if at least one is alive
                    ktpOrtuInput.setAttribute('required', 'required');
                }
            }

            statusAyah.addEventListener('change', updateParentLogic);
            statusIbu.addEventListener('change', updateParentLogic);
            updateParentLogic(); // trigger on load


            // --- 2. Address Logic ---
            const cbAlamatSama = document.getElementById('alamat_ortu_sama');
            const containerAlamatOrtu = document.getElementById('alamat_ortu_container');
            const overlayAlamatOrtu = document.getElementById('alamat_ortu_overlay');

            // Find main checkbox
            const checkboxes = document.querySelectorAll('input[name="alamat_ortu_sama"]');
            let mainCb = null;
            checkboxes.forEach(cb => { if (cb.type === 'checkbox') mainCb = cb; });

            // Fields to sync
            const provSdn = document.getElementById('provinsi');
            const kabSdn = document.getElementById('kabupaten');
            const kecSdn = document.getElementById('kecamatan');
            const desaSdn = document.getElementById('desa');
            const detailSdn = document.getElementById('alamat_detail');
            const rtSdn = document.getElementById('rt');
            const rwSdn = document.getElementById('rw');
            const posSdn = document.getElementById('kode_pos');

            const provTextSdn = document.getElementById('provinsi_text');
            const kabTextSdn = document.getElementById('kabupaten_text');
            const kecTextSdn = document.getElementById('kecamatan_text');
            const desaTextSdn = document.getElementById('desa_text');

            // Fields to target
            const provOrtu = document.getElementById('provinsi_ortu_select');
            const kabOrtu = document.getElementById('kabupaten_ortu_select');
            const kecOrtu = document.getElementById('kecamatan_ortu_select');
            const desaOrtu = document.getElementById('desa_ortu_select');
            const detailOrtu = document.getElementById('alamat_detail_ortu');
            const rtOrtu = document.getElementById('rt_ortu');
            const rwOrtu = document.getElementById('rw_ortu');
            const posOrtu = document.getElementById('kode_pos_ortu');

            const provTextOrtu = document.getElementById('provinsi_ortu_text');
            const kabTextOrtu = document.getElementById('kabupaten_ortu_text');
            const kecTextOrtu = document.getElementById('kecamatan_ortu_text');
            const desaTextOrtu = document.getElementById('desa_ortu_text');

            // Initial fetch for parent province
            fetch('/api/wilayah/provinces')
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">-- Pilih Provinsi --</option>';
                    data.forEach(prov => {
                        options += `<option value="${prov.id}">${prov.name}</option>`;
                    });
                    provOrtu.innerHTML = options;
                });

            provOrtu.addEventListener('change', function () {
                const id = this.value;
                provTextOrtu.value = this.options[this.selectedIndex]?.text || '';

                kabOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                kabOrtu.disabled = true;
                kecOrtu.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                kecOrtu.disabled = true;
                desaOrtu.innerHTML = '<option value="">-- Pilih Desa --</option>';
                desaOrtu.disabled = true;
                posOrtu.value = '';

                if (id) {
                    fetch(`/api/wilayah/regencies/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                            data.forEach(kab => {
                                options += `<option value="${kab.id}">${kab.name}</option>`;
                            });
                            kabOrtu.innerHTML = options;
                            if (!mainCb.checked) kabOrtu.disabled = false;
                        });
                }
            });

            kabOrtu.addEventListener('change', function () {
                const id = this.value;
                kabTextOrtu.value = this.options[this.selectedIndex]?.text || '';

                kecOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                kecOrtu.disabled = true;
                desaOrtu.innerHTML = '<option value="">-- Pilih Desa --</option>';
                desaOrtu.disabled = true;
                posOrtu.value = '';

                if (id) {
                    fetch(`/api/wilayah/districts/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kecamatan --</option>';
                            data.forEach(kec => {
                                options += `<option value="${kec.id}">${kec.name}</option>`;
                            });
                            kecOrtu.innerHTML = options;
                            if (!mainCb.checked) kecOrtu.disabled = false;
                        });
                }
            });

            kecOrtu.addEventListener('change', function () {
                const id = this.value;
                kecTextOrtu.value = this.options[this.selectedIndex]?.text || '';

                desaOrtu.innerHTML = '<option value="">-- Memuat... --</option>';
                desaOrtu.disabled = true;
                posOrtu.value = '';

                if (id) {
                    fetch(`/api/wilayah/villages/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                            data.forEach(desa => {
                                options += `<option value="${desa.id}" data-postal="${desa.postal_code || ''}">${desa.name}</option>`;
                            });
                            desaOrtu.innerHTML = options;
                            if (!mainCb.checked) desaOrtu.disabled = false;
                        });
                }
            });

            desaOrtu.addEventListener('change', function () {
                desaTextOrtu.value = this.options[this.selectedIndex]?.text || '';
                const postalCode = this.options[this.selectedIndex]?.getAttribute('data-postal') || '';
                if (postalCode && !posOrtu.value) posOrtu.value = postalCode;
            });

            function syncAlamatSama() {
                if (mainCb.checked) {
                    // Sync values
                    if (provSdn.options[provSdn.selectedIndex]) {
                        provOrtu.innerHTML = `<option value="${provSdn.value}">${provSdn.options[provSdn.selectedIndex].text}</option>`;
                        provTextOrtu.value = provTextSdn.value;
                    }
                    if (kabSdn.options[kabSdn.selectedIndex] && kabSdn.value) {
                        kabOrtu.innerHTML = `<option value="${kabSdn.value}">${kabSdn.options[kabSdn.selectedIndex].text}</option>`;
                        kabTextOrtu.value = kabTextSdn.value;
                    } else {
                        kabOrtu.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                        kabTextOrtu.value = '';
                    }
                    if (kecSdn.options[kecSdn.selectedIndex] && kecSdn.value) {
                        kecOrtu.innerHTML = `<option value="${kecSdn.value}">${kecSdn.options[kecSdn.selectedIndex].text}</option>`;
                        kecTextOrtu.value = kecTextSdn.value;
                    } else {
                        kecOrtu.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                        kecTextOrtu.value = '';
                    }
                    if (desaSdn.options[desaSdn.selectedIndex] && desaSdn.value) {
                        desaOrtu.innerHTML = `<option value="${desaSdn.value}">${desaSdn.options[desaSdn.selectedIndex].text}</option>`;
                        desaTextOrtu.value = desaTextSdn.value;
                    } else {
                        desaOrtu.innerHTML = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                        desaTextOrtu.value = '';
                    }

                    detailOrtu.value = detailSdn.value;
                    rtOrtu.value = rtSdn.value;
                    rwOrtu.value = rwSdn.value;
                    posOrtu.value = posSdn.value;
                }
            }

            let isAlamatLoad = true;
            function updateAlamatLogic() {
                if (mainCb.checked) {
                    overlayAlamatOrtu.style.display = 'block';
                    // Disable inputs so user can't interact, and they visually dim
                    provOrtu.disabled = true;
                    kabOrtu.disabled = true;
                    kecOrtu.disabled = true;
                    desaOrtu.disabled = true;
                    detailOrtu.readOnly = true;
                    rtOrtu.readOnly = true;
                    rwOrtu.readOnly = true;
                    posOrtu.readOnly = true;

                    // remove required attributes
                    provOrtu.removeAttribute('required');
                    kabOrtu.removeAttribute('required');
                    kecOrtu.removeAttribute('required');
                    desaOrtu.removeAttribute('required');
                    detailOrtu.removeAttribute('required');

                    syncAlamatSama();
                } else {
                    overlayAlamatOrtu.style.display = 'none';
                    // Re-enable inputs
                    provOrtu.disabled = false;
                    kabOrtu.disabled = !provOrtu.value;
                    kecOrtu.disabled = !kabOrtu.value;
                    desaOrtu.disabled = !kecOrtu.value;

                    detailOrtu.readOnly = false;
                    rtOrtu.readOnly = false;
                    rwOrtu.readOnly = false;
                    posOrtu.readOnly = false;

                    // add required attributes
                    provOrtu.setAttribute('required', 'required');
                    kabOrtu.setAttribute('required', 'required');
                    kecOrtu.setAttribute('required', 'required');
                    desaOrtu.setAttribute('required', 'required');
                    detailOrtu.setAttribute('required', 'required');

                    // If unchecked after a sync, we must restore the full list of options so the user can change them
                    if (!isAlamatLoad) {
                        const cProv = provOrtu.value;
                        const cKab = kabOrtu.value;
                        const cKec = kecOrtu.value;
                        const cDesa = desaOrtu.value;

                        fetch('/api/wilayah/provinces').then(r => r.json()).then(d => {
                            let opt = '<option value="">-- Pilih Provinsi --</option>';
                            d.forEach(x => opt += `<option value="${x.id}">${x.name}</option>`);
                            provOrtu.innerHTML = opt;
                            provOrtu.value = cProv;
                        });

                        if (cProv) {
                            fetch(`/api/wilayah/regencies/${cProv}`).then(r => r.json()).then(d => {
                                let opt = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                                d.forEach(x => opt += `<option value="${x.id}">${x.name}</option>`);
                                kabOrtu.innerHTML = opt;
                                kabOrtu.value = cKab;
                                kabOrtu.disabled = false;
                            });
                        }
                        if (cKab) {
                            fetch(`/api/wilayah/districts/${cKab}`).then(r => r.json()).then(d => {
                                let opt = '<option value="">-- Pilih Kecamatan --</option>';
                                d.forEach(x => opt += `<option value="${x.id}">${x.name}</option>`);
                                kecOrtu.innerHTML = opt;
                                kecOrtu.value = cKec;
                                kecOrtu.disabled = false;
                            });
                        }
                        if (cKec) {
                            fetch(`/api/wilayah/villages/${cKec}`).then(r => r.json()).then(d => {
                                let opt = '<option value="">-- Pilih Desa/Kelurahan --</option>';
                                d.forEach(x => opt += `<option value="${x.id}" data-postal="${x.postal_code || ''}">${x.name}</option>`);
                                desaOrtu.innerHTML = opt;
                                desaOrtu.value = cDesa;
                                desaOrtu.disabled = false;
                            });
                        }
                    }
                }
                isAlamatLoad = false;
            }

            mainCb.addEventListener('change', updateAlamatLogic);

            // Add listeners to student fields to live-sync if cb is checked
            [provSdn, kabSdn, kecSdn, desaSdn].forEach(el => el.addEventListener('change', () => {
                if (mainCb.checked) syncAlamatSama();
            }));
            [detailSdn, rtSdn, rwSdn, posSdn].forEach(el => el.addEventListener('input', () => {
                if (mainCb.checked) syncAlamatSama();
            }));

            // Initial trigger
            setTimeout(updateAlamatLogic, 100);


            // --- 3. Region API Call Implementation ---
            const url_provinsi = '/api/wilayah/provinces';

            function setupRegionGroup(groupPrefix) {
                const selectProv = document.getElementById(groupPrefix === 'siswa' ? 'provinsi' : 'provinsi_ortu_select');
                const selectKab = document.getElementById(groupPrefix === 'siswa' ? 'kabupaten' : 'kabupaten_ortu_select');
                const selectKec = document.getElementById(groupPrefix === 'siswa' ? 'kecamatan' : 'kecamatan_ortu_select');
                const selectDesa = document.getElementById(groupPrefix === 'siswa' ? 'desa' : 'desa_ortu_select');

                const textProv = document.getElementById(groupPrefix === 'siswa' ? 'provinsi_text' : 'provinsi_ortu_text');
                const textKab = document.getElementById(groupPrefix === 'siswa' ? 'kabupaten_text' : 'kabupaten_ortu_text');
                const textKec = document.getElementById(groupPrefix === 'siswa' ? 'kecamatan_text' : 'kecamatan_ortu_text');
                const textDesa = document.getElementById(groupPrefix === 'siswa' ? 'desa_text' : 'desa_ortu_text');

                let initProv = textProv.value;
                let initKab = textKab.value;
                let initKec = textKec.value;
                let initDesa = textDesa.value;

                // Load Provinsi
                fetch(url_provinsi)
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">-- Pilih Provinsi --</option>';
                        let provIdToLoad = null;
                        data.forEach(prov => {
                            let selected = (prov.name === initProv) ? 'selected' : '';
                            if (selected) provIdToLoad = prov.id;
                            options += `<option value="${prov.id}" data-name="${prov.name}" ${selected}>${prov.name}</option>`;
                        });
                        selectProv.innerHTML = options;

                        if (groupPrefix === 'siswa' && document.getElementById('alamat_ortu_sama')?.checked && typeof syncAlamatSama === 'function') {
                            syncAlamatSama();
                        }

                        if (provIdToLoad) {
                            loadKabupaten(provIdToLoad, initKab);
                        }
                    });

                function loadKabupaten(provId, selectedName) {
                    selectKab.innerHTML = '<option value="">-- Memuat... --</option>';
                    selectKab.disabled = true;
                    fetch(`/api/wilayah/regencies/${provId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                            let kabIdToLoad = null;
                            data.forEach(kab => {
                                let selected = (kab.name === selectedName) ? 'selected' : '';
                                if (selected) kabIdToLoad = kab.id;
                                options += `<option value="${kab.id}" data-name="${kab.name}" ${selected}>${kab.name}</option>`;
                            });
                            selectKab.innerHTML = options;
                            selectKab.disabled = false;

                            if (groupPrefix === 'siswa' && document.getElementById('alamat_ortu_sama')?.checked && typeof syncAlamatSama === 'function') {
                                syncAlamatSama();
                            }

                            if (kabIdToLoad) {
                                loadKecamatan(kabIdToLoad, initKec);
                            }
                        });
                }

                function loadKecamatan(kabId, selectedName) {
                    selectKec.innerHTML = '<option value="">-- Memuat... --</option>';
                    selectKec.disabled = true;
                    fetch(`/api/wilayah/districts/${kabId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Kecamatan --</option>';
                            let kecIdToLoad = null;
                            data.forEach(kec => {
                                let selected = (kec.name === selectedName) ? 'selected' : '';
                                if (selected) kecIdToLoad = kec.id;
                                options += `<option value="${kec.id}" data-name="${kec.name}" ${selected}>${kec.name}</option>`;
                            });
                            selectKec.innerHTML = options;
                            selectKec.disabled = false;

                            if (groupPrefix === 'siswa' && document.getElementById('alamat_ortu_sama')?.checked && typeof syncAlamatSama === 'function') {
                                syncAlamatSama();
                            }

                            if (kecIdToLoad) {
                                loadDesa(kecIdToLoad, initDesa);
                            }
                        });
                }

                function loadDesa(kecId, selectedName) {
                    selectDesa.innerHTML = '<option value="">-- Memuat... --</option>';
                    selectDesa.disabled = true;
                    fetch(`/api/wilayah/villages/${kecId}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">-- Pilih Desa --</option>';
                            data.forEach(desa => {
                                let selected = (desa.name === selectedName) ? 'selected' : '';
                                options += `<option value="${desa.id}" data-name="${desa.name}" data-postal="${desa.postal_code}" ${selected}>${desa.name}</option>`;
                            });
                            selectDesa.innerHTML = options;
                            selectDesa.disabled = false;

                            if (groupPrefix === 'siswa' && document.getElementById('alamat_ortu_sama')?.checked && typeof syncAlamatSama === 'function') {
                                syncAlamatSama();
                            }

                            initProv = null;
                            initKab = null;
                            initKec = null;
                            initDesa = null;
                        });
                }

                // On Provinsi change => load Kabupaten
                selectProv.addEventListener('change', (e) => {
                    selectKab.innerHTML = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                    selectKec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    selectDesa.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    selectKab.disabled = true;
                    selectKec.disabled = true;
                    selectDesa.disabled = true;

                    if (e.target.value) {
                        textProv.value = e.target.options[e.target.selectedIndex].dataset.name;
                        loadKabupaten(e.target.value, null);
                    } else {
                        textProv.value = '';
                    }
                });

                // On Kabupaten change => load Kecamatan
                selectKab.addEventListener('change', (e) => {
                    selectKec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    selectDesa.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    selectKec.disabled = true;
                    selectDesa.disabled = true;

                    if (e.target.value) {
                        textKab.value = e.target.options[e.target.selectedIndex].dataset.name;
                        loadKecamatan(e.target.value, null);
                    } else {
                        textKab.value = '';
                    }
                });

                // On Kecamatan change => load Desa
                selectKec.addEventListener('change', (e) => {
                    selectDesa.innerHTML = '<option value="">-- Pilih Desa --</option>';
                    selectDesa.disabled = true;

                    if (e.target.value) {
                        textKec.value = e.target.options[e.target.selectedIndex].dataset.name;
                        loadDesa(e.target.value, null);
                    } else {
                        textKec.value = '';
                    }
                });

                // On Desa change
                selectDesa.addEventListener('change', (e) => {
                    if (e.target.value) {
                        const namaDesa = e.target.options[e.target.selectedIndex].dataset.name;
                        const postalCode = e.target.options[e.target.selectedIndex].dataset.postal;
                        textDesa.value = namaDesa;

                        const inputKodePos = document.getElementById(groupPrefix === 'siswa' ? 'kode_pos' : 'kode_pos_ortu');
                        if (inputKodePos && postalCode) {
                            if (!initDesa) inputKodePos.value = postalCode;
                        }

                    } else {
                        textDesa.value = '';
                    }
                });
            }

            setupRegionGroup('siswa');
            setupRegionGroup('ortu');
        });
    </script>
</x-registration-layout>
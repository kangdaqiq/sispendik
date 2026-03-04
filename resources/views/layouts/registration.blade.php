<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pendaftaran Siswa Baru') }} - Pendaftaran</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts via local vendor -->
    <script src="{{ asset('vendor/tailwind/tailwindcss.js') }}"></script>
    <script defer src="{{ asset('vendor/alpine/alpine.min.js') }}"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
        }

        .header-bar {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #1e3a5f 100%);
            border-bottom: 3px solid #f59e0b;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
        }

        .logo-ring {
            background: rgba(255, 255, 255, 0.12);
            border: 2px solid rgba(255, 255, 255, 0.25);
            border-radius: 9999px;
            padding: 3px;
        }

        .school-name {
            color: #fbbf24;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .back-link {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #fbbf24;
        }
    </style>
</head>

<body class="font-sans text-gray-800 antialiased min-h-screen">

    <!-- Header -->
    <div class="header-bar">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo-smk.png') }}" alt="Logo SMK" class="h-14 w-14 object-contain">
                    <div>
                        <span class="font-bold text-lg text-white block leading-tight tracking-tight">
                            Form Pendaftaran Siswa Baru
                        </span>
                        <span class="school-name">SMK Assuniyah Tumijajar</span>
                    </div>
                </div>
                <div>
                    <a href="/" class="back-link">&larr; Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="mt-12 py-6 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} {{ config('app.name', 'Sistem Informasi Sekolah') }}. Hak Cipta Dilindungi.
    </footer>

</body>

</html>
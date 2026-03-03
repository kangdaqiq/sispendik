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
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f6f8fd 0%, #f1f5f9 100%);
        }
    </style>
</head>

<body class="font-sans text-gray-800 antialiased gradient-bg min-h-screen">

    <!-- Header -->
    <div class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-white p-1 rounded-full">
                        <x-application-logo class="w-8 h-8 text-indigo-600" />
                    </div>
                    <span class="font-bold text-xl tracking-tight">Form Pendaftaran Siswa Baru</span>
                </div>
                <div>
                    <a href="/" class="text-indigo-100 hover:text-white transition-colors text-sm font-medium">
                        &larr; Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="mt-12 py-6 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} {{ config('app.name', 'Sistem Informasi Sekolah') }}. Hak Cipta Dilindungi.
    </footer>

</body>

</html>
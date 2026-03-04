<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SISPENDIK') }} - Portal Layanan</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('icon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts via local vendor -->
    <script src="{{ asset('vendor/tailwind/tailwindcss.js') }}"></script>
    <script defer src="{{ asset('vendor/alpine/alpine.min.js') }}"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .auth-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Abstract background shapes */
        .auth-bg::before {
            content: '';
            position: absolute;
            top: -15%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(22, 163, 74, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .auth-bg::after {
            content: '';
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 440px;
            z-index: 10;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .auth-header {
            padding: 3rem 2rem 1.5rem;
            text-align: center;
        }

        .auth-body {
            padding: 1rem 2.5rem 3rem;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-header">
                <a href="/" class="inline-block relative">
                    <div class="absolute inset-0 bg-blue-100 rounded-full blur-md opacity-60"></div>
                    <img src="{{ asset('logo-smk.png') }}" alt="Logo SMK"
                        class="relative w-24 h-24 mx-auto object-contain drop-shadow-md" />
                </a>
                <h2 class="mt-6 text-2xl font-bold text-gray-800 tracking-tight">Sistem Informasi Akademik</h2>
                <p class="mt-2 text-sm text-gray-500 font-medium">SMK Assuniyah Tumijajar</p>
            </div>

            <div class="auth-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
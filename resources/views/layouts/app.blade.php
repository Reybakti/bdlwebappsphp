<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT BPR Bank Daerah Lamongan (Perseroda)')</title>
    
    <!-- Favicon Logo BDL Resmi -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-bdl.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo-bdl.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        num: ['"Outfit"', '"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        bdl: {
                            white: '#FFFFFF',
                            soft: '#D6E4F0',
                            primary: '#1E56A0',
                            navy: '#163172',
                        }
                    }
                }
            }
        }
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .tabular-nums { font-variant-numeric: tabular-nums; }
        .font-num {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            font-feature-settings: "cv11", "tnum";
            letter-spacing: -0.01em;
        }
    </style>
</head>
<body class="bg-white text-slate-800 font-sans antialiased flex flex-col min-h-screen">

    <!-- Komponen Navbar Header -->
    <x-navbar />

    <!-- Konten Halaman -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Komponen Footer Kepatuhan -->
    <x-footer />

    @yield('scripts')
</body>
</html>
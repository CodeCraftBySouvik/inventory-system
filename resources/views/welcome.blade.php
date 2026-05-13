<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);">

        
        

        {{-- Content --}}
        <div class="relative z-10 flex flex-col items-center text-center px-4">

           

            {{-- Title --}}
            <h1 class="text-5xl font-bold text-white drop-shadow-lg tracking-tight">
                Inventory System
            </h1>
            <p class="mt-3 text-white text-lg">
                Manage your products with ease
            </p>

            {{-- Divider --}}
            <div class="mt-6 mb-6 w-16 h-1 bg-blue-400 rounded-full opacity-60"></div>

            {{-- Auth Buttons --}}
            @if (Route::has('login'))
                <div class="flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-lg transition duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-8 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-lg transition duration-200">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-8 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg shadow-lg border border-white/30 backdrop-blur-sm transition duration-200">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Inventory System')</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('style')

</head>

<body class="bg-gray-100">

<div class="flex">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Main Content --}}
    <div class="flex-1">

        {{-- Navbar --}}
        <nav class="bg-white shadow px-6 py-4 flex justify-between">

            <div class="font-bold text-lg">
                @yield('page-title')
            </div>

            <div class="relative">

    {{-- User Button --}}
    <button
        id="userDropdownBtn"
        onclick="toggleDropdown()"
        class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition">

            <span>
                {{ Auth::user()->name }}
            </span>

            {{-- Down Arrow --}}
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7" />

            </svg>

        </button>

        {{-- Dropdown Menu --}}
        <div id="userDropdown"
            class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg border z-50">

            <form method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                        class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-500 rounded-lg">

                    Logout

                </button>

            </form>

        </div>

    </div>

        </nav>

        {{-- Page Content --}}
        <main class="p-6">

            @yield('content')

        </main>

    </div>

</div>

@yield('script')
<script>

    function toggleDropdown()
    {
        document.getElementById('userDropdown')
            .classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e)
    {
        const dropdown = document.getElementById('userDropdown');

        const button = document.getElementById('userDropdownBtn');

        if(!button.contains(e.target) && !dropdown.contains(e.target))
        {
            dropdown.classList.add('hidden');
        }
    });

</script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('peminjaman_alat_logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.boxicons.com/3.0.8/fonts/basic/boxicons.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            --tw-outline-style: none;
            outline-style: none;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Overlay for mobile (lebih transparan) -->
    <div id="sidebar-overlay"
        class="lg:hidden fixed inset-0 bg-black opacity-30 z-30 hidden transition-opacity duration-300"
        onclick="toggleSidebar()"></div>

    <!-- Sidebar (Fixed) -->
    @include('layouts.sidebar')

    <!-- Main Content Area (with margin-left for sidebar) -->
    <div class="lg:ml-64">
        <!-- Mobile Toggle Button (Outside Sidebar) - Fixed positioning yang tidak menimpa -->
        <div class="lg:hidden sticky top-0 z-20 bg-white shadow-sm">
            <div class="flex items-center justify-between p-4">
                <button onclick="toggleSidebar()" class="rounded-lg">
                    <i class='bx bx-menu text-2xl text-black'></i>
                </button>
                <h1 class="text-lg font-semibold text-gray-800">Peminjaman Alat</h1>
                <div class="w-10"></div> <!-- Spacer untuk balance -->
            </div>
        </div>

        <!-- Page Content (Scrollable) -->
        <main class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

    
    </div>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');

            // Prevent body scroll when sidebar is open
            if (!sidebar.classList.contains('-translate-x-full')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }

        // Close sidebar when clicking on a link (mobile only)
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth < 1024) {
                const sidebarLinks = document.querySelectorAll('#sidebar a:not(#mobile-toggle-btn)');
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        toggleSidebar();
                    });
                });
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.body.style.overflow = 'auto';
            }
        });
    </script>

</body>

</html>

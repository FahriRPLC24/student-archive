<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentArchive - Guru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-[#F4F6F9] text-gray-800 overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        
        <!-- OVERLAY GELAP -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity"></div>

        <!-- SIDEBAR GURU -->
        <aside id="sidebar" class="w-[220px] bg-[#0A1120] text-white flex flex-col shadow-xl z-40 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="h-16 flex items-center justify-between px-5">
                <div class="flex items-center">
                    <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-[15px] font-bold leading-tight">StudentArchive</h1>
                        <p class="text-[9px] text-gray-400">GURU / OPERATOR</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigasi Guru -->
            <nav class="flex-1 px-2 mt-4 space-y-1">
                <a href="{{ route('guru.dashboard') }}" class="flex items-center space-x-3 {{ request()->routeIs('guru.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} px-3 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-[13px] font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('guru.dokumen') }}" class="flex items-center space-x-3 {{ request()->routeIs('guru.dokumen') || request()->routeIs('guru.detail') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} px-3 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-[13px] font-medium">Data & Dokumen</span>
                </a>

                <a href="{{ route('guru.laporan') }}" class="flex items-center space-x-3 {{ request()->routeIs('guru.laporan') ? 'bg-blue-600 text-white' : 'text-gray-400 hover:bg-white/5 hover:text-white' }} px-3 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-[13px] font-medium">Laporan</span>
                </a>
            </nav>

            <div class="p-4">
                <div class="text-[10px] text-gray-500 mb-4 leading-relaxed hidden sm:block">
                    Dashboard → Data & Dokumen → Laporan.
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-2 text-red-400 hover:text-red-300 transition text-[13px] font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA GURU -->
        <main class="flex-1 flex flex-col overflow-hidden w-full">
            <header class="h-14 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-6">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <span class="font-medium text-gray-800 text-sm">@yield('title', 'Dashboard Guru')</span>
                </div>
                
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-full px-3 py-1">
                    <div class="w-6 h-6 bg-purple-600 rounded-full flex items-center justify-center text-[10px] font-bold text-white">
                        {{ substr(Auth::user()->name ?? 'GR', 0, 2) }}
                    </div>
                    <div class="overflow-hidden max-w-[100px] sm:max-w-[150px]">
                        <p class="text-[11px] font-bold text-gray-800 leading-tight truncate">{{ Auth::user()->name ?? 'Guru' }}</p>
                        <p class="text-[9px] text-gray-500 hidden sm:block">Guru / Operator</p>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 md:p-6">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentArchive - Siswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-[#F8FAFC] text-gray-800 overflow-x-hidden">
    
    <!-- NAVBAR ATAS -->
    <nav class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8 w-full">
        <div class="flex items-center gap-2 md:gap-6">
            <!-- Logo -->
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <h1 class="text-lg font-bold text-gray-900 hidden sm:block">StudentArchive</h1>
                <span class="border border-blue-200 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded hidden md:block">PORTAL SISWA</span>
            </div>
            
            <!-- Search Bar (Sembunyi di HP, Muncul di Laptop) -->
            <form action="{{ route('siswa.dashboard') }}" method="GET" class="relative w-64 ml-4 hidden md:block">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis dokumen..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </form>
        </div>

        <div class="flex items-center gap-2 md:gap-4 shrink-0">
            <!-- Profil & Logout -->
            <div class="flex items-center gap-2 md:gap-3 pl-2 md:pl-4 md:border-l border-gray-200">
                <div class="text-right hidden md:block">
                    <p class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'Muhammad Fahri' }}</p>
                    <p class="text-[11px] text-gray-500">{{ Auth::user()->classRoom->name ?? 'XII RPL C' }}</p>
                </div>
                <div class="w-8 h-8 bg-[#11223F] rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                    {{ substr(Auth::user()->name ?? 'MF', 0, 2) }}
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="ml-1 md:ml-2">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA (w-full min-w-0 agar tidak melebar) -->
    <main class="w-full min-w-0 max-w-[1200px] mx-auto p-4 md:p-6 mt-2 overflow-hidden">
        @yield('content')
    </main>

</body>
</html>
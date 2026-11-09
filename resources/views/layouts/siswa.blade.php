<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentArchive - Siswa</title>

    <!-- FAVICON BARU (SVG) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563EB'%3E%3Crect width='24' height='24' rx='6' fill='%232563EB'/%3E%3Cpath d='M6 8h12v2H6V8zm0 3h12v7a1 1 0 01-1 1H7a1 1 0 01-1-1v-7zm3 3h6v2H9v-2z' fill='white'/%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<!-- ... sisa kode layout ... -->
<body class="bg-[#F8FAFC] text-gray-800 overflow-x-hidden">
    
    <!-- NAVBAR ATAS -->
    <nav class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8 w-full">
        <div class="flex items-center gap-2 md:gap-6">
            
            <!-- LOGO & NAMA WEB -->
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <h1 class="text-base md:text-lg font-bold text-gray-900">StudentArchive</h1>
                <span class="border border-blue-200 bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded hidden lg:block">PORTAL SISWA</span>
            </div>
            
            <!-- Search Bar (Hanya Muncul di Laptop) -->
            <form action="{{ route('siswa.dashboard') }}" method="GET" class="relative w-64 ml-4 hidden md:block">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari jenis dokumen..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </form>
        </div>

        <div class="flex items-center gap-2 md:gap-4 shrink-0">
            <div class="flex items-center gap-2 md:gap-3 pl-2 md:pl-4 md:border-l border-gray-200">
                
                <!-- NAMA PENGGUNA (Muncul di semua ukuran layar) -->
                <div class="text-right">
                    <p class="text-[11px] md:text-sm font-bold text-gray-800 leading-tight max-w-[120px] md:max-w-[200px] truncate">{{ Auth::user()->name ?? 'Siswa' }}</p>
                    <p class="text-[9px] md:text-[11px] text-gray-500">{{ Auth::user()->classRoom->name ?? 'XII RPL C' }}</p>
                </div>
                
                <!-- Inisial Bulat (Disembunyikan di HP agar tidak sesak, muncul di Tablet/Laptop) -->
                <div class="hidden sm:flex w-8 h-8 bg-[#11223F] rounded-full items-center justify-center text-white text-xs font-bold shrink-0">
                    {{ substr(Auth::user()->name ?? 'MF', 0, 2) }}
                </div>
                
                <!-- Tombol Logout -->
                <button type="button" onclick="document.getElementById('modalLogout').style.display = 'flex'" class="ml-1 md:ml-2 text-gray-400 hover:text-red-500 transition" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main class="w-full min-w-0 max-w-[1200px] mx-auto p-4 md:p-6 mt-2 overflow-hidden">
        @yield('content')
    </main>

    <!-- MODAL KONFIRMASI LOGOUT -->
    <div id="modalLogout" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6" style="margin: auto; position: relative;">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Keluar Sistem?</h3>
            <p class="text-sm text-gray-500 text-center mb-6">Apakah Anda yakin ingin keluar dari akun ini?</p>
            
            <div class="flex justify-center gap-3">
                <button type="button" onclick="document.getElementById('modalLogout').style.display = 'none'" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition">Logout</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
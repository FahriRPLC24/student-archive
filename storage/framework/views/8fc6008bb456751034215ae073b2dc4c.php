<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentArchive - <?php echo $__env->yieldContent('title', 'Kurikulum'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-[#F4F6F9] text-gray-800 overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        
        <!-- OVERLAY GELAP (Mobile) -->
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden transition-opacity"></div>

        <!-- SIDEBAR -->
        <aside id="sidebar" class="w-[260px] bg-[#0B1527] text-white flex flex-col shadow-xl z-40 fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">
            <div class="h-20 flex items-center justify-between px-6 mb-2">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-[17px] font-bold leading-tight">StudentArchive</h1>
                        <p class="text-[11px] text-gray-400">KURIKULUM</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="px-6 mb-2 mt-2">
                <p class="text-[10px] font-bold text-gray-500 tracking-wider">UTAMA</p>
            </div>

            <nav class="flex-1 px-3 space-y-1 overflow-y-auto">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.verifikasi')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.verifikasi') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-sm font-medium">Verifikasi Berkas</span>
                </a>

                <div class="px-3 pt-6 pb-2">
                    <p class="text-[10px] font-bold text-gray-500 tracking-wider">KELOLA DATA</p>
                </div>

                <a href="<?php echo e(route('admin.siswa')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.siswa') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="text-sm font-medium">Data Siswa</span>
                </a>
                <a href="<?php echo e(route('admin.users')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.users') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-sm font-medium">Data Pengguna</span>
                </a>
                <a href="<?php echo e(route('admin.kelas')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.kelas') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="text-sm font-medium">Kelas & Jurusan</span>
                </a>
                <a href="<?php echo e(route('admin.upload-kolektif')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.upload-kolektif') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span class="text-sm font-medium">Upload Kolektif</span>
                </a>

                <div class="px-3 pt-6 pb-2">
                    <p class="text-[10px] font-bold text-gray-500 tracking-wider">LAPORAN</p>
                </div>
                
                <a href="<?php echo e(route('admin.rekap')); ?>" class="flex items-center space-x-3 <?php echo e(request()->routeIs('admin.rekap') ? 'bg-blue-600/20 text-blue-400 border-l-4 border-blue-500' : 'text-gray-400 hover:bg-white/5 hover:text-white border-l-4 border-transparent'); ?> px-4 py-2.5 rounded-r-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="text-sm font-medium">Rekap Kelengkapan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <div class="flex items-center space-x-3 p-2 rounded-xl">
                    <div class="w-9 h-9 bg-purple-600 rounded-full flex items-center justify-center text-sm font-bold">
                        <?php echo e(substr(Auth::user()->name ?? 'KR', 0, 2)); ?>

                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-semibold truncate"><?php echo e(Auth::user()->name ?? 'Kurikulum'); ?></p>
                        <p class="text-[10px] text-gray-400 capitalize">Kurikulum</p>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-gray-400 hover:text-red-400 transition" title="Logout">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 flex flex-col overflow-hidden w-full min-w-0">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8 shrink-0">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-800">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <span class="font-medium text-gray-800 text-sm md:text-base"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></span>
                </div>
                
                <!-- FORM PENCARIAN DINAMIS MENYESUAIKAN HALAMAN -->
                <?php if(request()->routeIs('admin.siswa')): ?>
                    <form action="<?php echo e(route('admin.siswa')); ?>" method="GET" class="relative w-full max-w-[200px] md:max-w-[300px]">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari siswa..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </form>
                <?php elseif(request()->routeIs('admin.users')): ?>
                    <form action="<?php echo e(route('admin.users')); ?>" method="GET" class="relative w-full max-w-[200px] md:max-w-[300px]">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari pengguna..." class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </form>
                <?php endif; ?>
            </header>

            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                <?php echo $__env->yieldContent('content'); ?>
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
</html><?php /**PATH C:\Users\ASM1\student-archive\resources\views/layouts/admin.blade.php ENDPATH**/ ?>
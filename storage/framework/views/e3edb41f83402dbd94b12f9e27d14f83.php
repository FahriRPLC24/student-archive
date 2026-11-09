<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Overview Dashboard</h2>
</div>

<!-- 4 Card Statistik Dinamis -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden">
        <p class="text-[11px] text-gray-500 uppercase font-bold mb-1">Total Siswa</p>
        <h3 class="text-3xl font-bold text-[#0B1527]"><?php echo e($totalSiswa); ?></h3>
        <p class="text-[10px] text-green-500 mt-1">Siswa Terdaftar</p>
        <div class="absolute right-4 top-4 text-blue-500 bg-blue-50 p-2 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden">
        <p class="text-[11px] text-gray-500 uppercase font-bold mb-1">Total Guru</p>
        <h3 class="text-3xl font-bold text-[#0B1527]"><?php echo e($totalGuru); ?></h3>
        <p class="text-[10px] text-orange-500 mt-1">Guru Terdaftar</p>
        <div class="absolute right-4 top-4 text-orange-500 bg-orange-50 p-2 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden">
        <p class="text-[11px] text-gray-500 uppercase font-bold mb-1">Total Dokumen</p>
        <h3 class="text-3xl font-bold text-[#0B1527]"><?php echo e($totalDokumen); ?></h3>
        <p class="text-[10px] text-blue-500 mt-1">Seluruh Berkas</p>
        <div class="absolute right-4 top-4 text-green-500 bg-green-50 p-2 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative overflow-hidden">
        <p class="text-[11px] text-gray-500 uppercase font-bold mb-1">Kelengkapan</p>
        <h3 class="text-3xl font-bold text-[#0B1527]"><?php echo e($persenKelengkapan); ?>%</h3>
        <p class="text-[10px] text-red-500 mt-1">Rata-rata Global</p>
        <div class="absolute right-4 top-4 text-red-500 bg-red-50 p-2 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Lenovo\student-archive\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
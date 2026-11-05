

<?php $__env->startSection('title', 'Laporan'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Laporan</h2>
        <p class="text-sm text-gray-500 mt-1">Rekapitulasi kelengkapan dokumen untuk kelas <b><?php echo e($kelasDiampu->name ?? '-'); ?></b>.</p>
    </div>
    <div class="flex gap-2">
        <select class="border border-gray-200 rounded text-xs px-3 py-1.5 bg-white focus:outline-none">
            <option>2025/2026</option>
        </select>
        
        <!-- Tombol PDF Berfungsi -->
        <a href="<?php echo e(route('guru.laporan.export-pdf')); ?>" class="bg-white border border-gray-300 rounded text-xs px-4 py-1.5 font-bold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            PDF
        </a>
    </div>
</div>

<!-- 4 Card Statistik Dinamis -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">SISWA TERDATA</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($totalSiswa); ?></h3>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">DOKUMEN</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($totalDokumen); ?></h3>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">LENGKAP</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($persenLengkap); ?>%</h3>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">BELUM LENGKAP</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($persenBelumLengkap); ?>%</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Kelengkapan per Kelas -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <h3 class="text-sm font-bold text-gray-800 mb-5">Kelengkapan per Kelas</h3>
        <div class="space-y-4">
            <?php $__currentLoopData = $rekapKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div class="flex justify-between text-[11px] font-bold text-gray-700 mb-1">
                    <span><?php echo e($rekap['name']); ?></span>
                    <span><?php echo e($rekap['persen']); ?>%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: <?php echo e($rekap['persen']); ?>%"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Rekap Jenis Dokumen -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <h3 class="text-sm font-bold text-gray-800 mb-5">Rekap Jenis Dokumen</h3>
        <div class="space-y-4">
            <?php $__currentLoopData = $rekapJenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div class="flex justify-between text-[11px] font-bold text-gray-700 mb-1">
                    <span><?php echo e($jenis['name']); ?></span>
                    <span><?php echo e($jenis['persen']); ?>%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="<?php echo e($jenis['persen'] == 100 ? 'bg-green-500' : 'bg-blue-600'); ?> h-1.5 rounded-full" style="width: <?php echo e($jenis['persen']); ?>%"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<div class="mt-6 flex gap-2">
    <!-- Tombol Cetak Rekap (Trigger Print Browser) -->
    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Cetak Rekap
    </button>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/guru/laporan.blade.php ENDPATH**/ ?>
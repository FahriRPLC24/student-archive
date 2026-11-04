

<?php $__env->startSection('title', 'Rekapitulasi Kelengkapan Berkas'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <!-- Header Card -->
    <div class="flex justify-between items-start mb-8 pb-6 border-b border-gray-100">
        <div>
            <p class="text-xs text-gray-500 mb-1">Tahun Ajaran: <span class="font-bold text-gray-800">2025/2026 Ganjil</span></p>
            <p class="text-xs text-gray-500">2025/2026 Genap</p>
        </div>
        <div class="flex gap-2">
            <!-- Tombol Cetak (Trigger Print Browser) -->
            <button onclick="window.print()" class="border border-gray-300 rounded-lg text-sm px-4 py-2 font-medium hover:bg-gray-50 flex items-center gap-2 text-gray-700 bg-white shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
            
            <!-- Tombol Download PDF (Fungsional) -->
            <a href="<?php echo e(route('admin.siswa.export-pdf')); ?>" class="bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-sm px-4 py-2 font-medium flex items-center gap-2 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download PDF Report
            </a>
        </div>
    </div>

    <!-- Progress Section -->
    <div class="mb-8">
        <h4 class="text-xs font-bold text-gray-700 mb-6 uppercase tracking-wide">Persentase Kelengkapan Per Kelas</h4>
        
        <div class="space-y-6">
            <?php $__currentLoopData = $rekapKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-medium text-gray-700"><?php echo e($rekap['name']); ?> (<?php echo e($rekap['siswa']); ?> Siswa)</span>
                    <span class="font-bold text-gray-900"><?php echo e($rekap['persen']); ?>%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3">
                    <!-- Warna menyesuaikan persentase -->
                    <div class="h-3 rounded-full <?php echo e($rekap['persen'] >= 80 ? 'bg-[#10b981]' : ($rekap['persen'] >= 50 ? 'bg-[#4F46E5]' : 'bg-[#f59e0b]')); ?>" style="width: <?php echo e($rekap['persen']); ?>%"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="text-sm text-gray-500 pt-6 border-t border-gray-100">
        Menampilkan ringkasan kelengkapan dari <?php echo e(array_sum(array_column($rekapKelas, 'siswa'))); ?> siswa di seluruh kelas.
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/admin/rekap.blade.php ENDPATH**/ ?>
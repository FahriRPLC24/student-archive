

<?php $__env->startSection('title', 'Dashboard Guru'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Dashboard Guru</h2>
    <p class="text-sm text-gray-500 mt-1">Pantau statistik dan kelengkapan data siswa <b><?php echo e($kelasDiampu->name ?? 'Anda'); ?></b>.</p>
</div>

<!-- 4 Card Statistik Dinamis -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">TOTAL SISWA</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($totalSiswa); ?></h3>
        <p class="text-[10px] text-green-500 font-medium mt-1">Siswa Kelas Anda</p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">DOKUMEN TERSIMPAN</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($totalDokumen); ?></h3>
        <p class="text-[10px] text-green-500 font-medium mt-1">Total Berkas</p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">PERLU UPDATE</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($perluUpdate); ?></h3>
        <p class="text-[10px] text-orange-500 font-medium mt-1">Menunggu Verifikasi</p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">KELENGKAPAN</p>
        <h3 class="text-2xl font-bold text-gray-800"><?php echo e($persenKelengkapan); ?>%</h3>
        <p class="text-[10px] text-blue-500 font-medium mt-1">Rata-rata Kelas</p>
    </div>
</div>

<!-- Aksi Cepat -->
<div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-sm font-bold text-gray-800">Aksi Cepat</h3>
    </div>
    <div class="flex gap-2">
        <a href="<?php echo e(route('guru.dokumen')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">Upload Dokumen</a>
        <a href="<?php echo e(route('guru.laporan')); ?>" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">Lihat Laporan</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Perlu Perhatian (Tabel Dinamis) -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-gray-800">Perlu Perhatian</h3>
            <a href="<?php echo e(route('guru.dokumen')); ?>" class="text-xs text-blue-600 font-medium hover:underline">Lihat semua</a>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] text-gray-400 uppercase tracking-wider border-b border-gray-100">
                    <th class="pb-2 font-bold">SISWA</th>
                    <th class="pb-2 font-bold">DOKUMEN</th>
                    <th class="pb-2 font-bold">STATUS</th>
                    <th class="pb-2 font-bold text-right">AKSI</th>
                </tr>
            </thead>
            <tbody class="text-xs divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $perluPerhatian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="py-2.5 font-bold text-gray-800"><?php echo e($doc->student->name); ?></td>
                    <td class="py-2.5 text-gray-600"><?php echo e($doc->type->name); ?></td>
                    <td class="py-2.5">
                        <?php if($doc->status == 'pending'): ?>
                            <span class="bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-[10px] font-bold">● Perlu Update</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded text-[10px] font-bold">● Ditolak</span>
                        <?php endif; ?>
                    </td>
                    <td class="py-2.5 text-right">
                        <a href="<?php echo e(route('guru.detail', $doc->student_id)); ?>" class="text-blue-600 font-medium">Edit</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">Tidak ada dokumen yang perlu diperhatikan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Kelengkapan Per Kelas (Dinamis) -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        <h3 class="text-sm font-bold text-gray-800 mb-4">Kelengkapan per Kelas</h3>
        <div class="space-y-4">
            <?php $__currentLoopData = $rekapKelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rekap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <div class="flex justify-between text-[11px] font-bold text-gray-700 mb-1">
                    <span><?php echo e($rekap['name']); ?></span>
                    <span><?php echo e($rekap['persen']); ?>%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <!-- Warna biru jika di atas 80%, kuning jika di bawah -->
                    <div class="h-1.5 rounded-full <?php echo e($rekap['persen'] >= 80 ? 'bg-blue-600' : 'bg-[#f59e0b]'); ?>" style="width: <?php echo e($rekap['persen']); ?>%"></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guru', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/guru/dashboard.blade.php ENDPATH**/ ?>


<?php $__env->startSection('content'); ?>
<!-- BANNER SAPAAN (Navy) -->
<div class="bg-[#11223F] rounded-2xl p-5 md:p-8 text-white mb-6 relative overflow-hidden shadow-lg w-full">
    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 opacity-10 rounded-full -mr-20 -mt-20 blur-2xl"></div>
    
    <div class="relative z-10">
        <h2 class="text-xl md:text-2xl font-bold mb-1">Selamat datang kembali, <?php echo e($siswa->name); ?>!</h2>
        <p class="text-[11px] md:text-[13px] text-gray-400 mb-4 md:mb-6"><?php echo e($siswa->classRoom->name ?? '-'); ?> - NIS <?php echo e($siswa->nis); ?></p>
        
        <div class="flex items-center gap-3 md:gap-4 mb-2">
            <span class="text-2xl md:text-3xl font-bold"><?php echo e($persen); ?>%</span>
            <span class="text-[10px] md:text-xs text-gray-300"><?php echo e($terverifikasi); ?> dari <?php echo e($totalWajib); ?> Dokumen Terkumpul</span>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-full bg-white/10 rounded-full h-2 md:h-2.5 mb-6">
            <div class="bg-blue-500 h-2 md:h-2.5 rounded-full transition-all duration-500" style="width: <?php echo e($persen); ?>%"></div>
        </div>

        <?php if($missingTypes->count() > 0): ?>
        <div class="bg-white/5 border border-white/10 rounded-lg p-2 md:p-3 text-[11px] md:text-xs flex flex-col md:flex-row items-start md:items-center gap-1 md:gap-2 text-gray-200">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                Perhatian: <?php echo e($missingTypes->first()->name); ?> belum diunggah. 
            </div>
            <a href="https://wa.me/<?php echo e($waliKelas->no_hp ?? '6281234567890'); ?>?text=Halo%20Bu%20<?php echo e(urlencode($waliKelas->name ?? 'Wali Kelas')); ?>%2C%20saya%20<?php echo e(urlencode($siswa->name)); ?>%20ingin%20bertanya%20mengenai%20dokumen%20yang%20belum%20saya%20unggah." target="_blank" class="underline font-bold ml-1 hover:text-white">Hubungi Wali Kelas</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($search): ?>
<div class="mb-4 text-sm text-gray-600">
    Menampilkan hasil pencarian untuk: <b>"<?php echo e($search); ?>"</b>. <a href="<?php echo e(route('siswa.dashboard')); ?>" class="text-blue-600 hover:underline">Reset</a>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 w-full">
    
    <!-- KIRI: Dokumen Terbaru -->
    <div class="lg:col-span-2 w-full min-w-0">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="text-base md:text-lg font-bold text-gray-800">Dokumen Terbaru</h3>
                <p class="text-[11px] md:text-xs text-gray-500">Ringkasan status berkas kamu</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
            <?php $__empty_1 = true; $__currentLoopData = $recentDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-200 rounded-xl p-3 md:p-4 shadow-sm w-full min-w-0">
                <div class="flex justify-between items-start mb-3">
                    <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    
                    <?php if($doc->status == 'verified'): ?>
                        <span class="bg-green-100 text-green-700 text-[9px] md:text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div> Terverifikasi
                        </span>
                    <?php elseif($doc->status == 'pending'): ?>
                        <span class="bg-yellow-100 text-yellow-700 text-[9px] md:text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></div> Menunggu
                        </span>
                    <?php else: ?>
                        <span class="bg-red-100 text-red-700 text-[9px] md:text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1">
                            <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div> Ditolak
                        </span>
                    <?php endif; ?>
                </div>
                
                <h4 class="font-bold text-gray-800 text-xs md:text-sm mb-1 truncate"><?php echo e($doc->type->name); ?></h4>
                <p class="text-[10px] md:text-[11px] text-gray-500 mb-4">
                    <?php echo e($doc->status == 'pending' ? 'Diunggah' : 'Diverifikasi'); ?> 
                    <?php echo e($doc->uploaded_at ? $doc->uploaded_at->format('d M Y') : '-'); ?>

                </p>
                
                <!-- LOGIKA TOMBOL AKSI -->
                <div class="flex gap-2">
                    <?php if($doc->status == 'verified'): ?>
                        <!-- Jika Verified: Tampilkan Lihat & Unduh -->
                        <a href="<?php echo e(asset('storage/' . $doc->file_path)); ?>" target="_blank" class="flex-1 border border-gray-200 rounded-lg py-1.5 text-[10px] md:text-xs font-medium text-gray-600 hover:bg-gray-50 flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg> 
                            Lihat
                        </a>
                        <a href="<?php echo e(asset('storage/' . $doc->file_path)); ?>" download class="flex-1 border border-gray-200 rounded-lg py-1.5 text-[10px] md:text-xs font-medium text-gray-600 hover:bg-gray-50 flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> 
                            Unduh
                        </a>
                    <?php elseif($doc->status == 'pending'): ?>
                        <!-- Jika Pending: Sembunyikan tombol, ganti dengan teks -->
                        <div class="w-full text-center py-2 text-[10px] md:text-xs text-gray-400 italic bg-gray-50 rounded-lg">
                            Menunggu Verifikasi Admin
                        </div>
                    <?php else: ?>
                        <!-- Jika Ditolak: Sembunyikan tombol, ganti dengan teks -->
                        <div class="w-full text-center py-2 text-[10px] md:text-xs text-red-500 font-medium bg-red-50 rounded-lg">
                            Berkas Ditolak. Silakan hubungi Guru.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-1 sm:col-span-2 bg-white border border-gray-200 rounded-xl p-8 text-center shadow-sm w-full">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <p class="text-gray-500 font-medium text-xs md:text-sm"><?php echo e($search ? 'Dokumen tidak ditemukan.' : 'Belum ada dokumen yang diunggah oleh Guru.'); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- KANAN: Aktivitas & Kontak -->
    <div class="lg:col-span-1 space-y-4 md:space-y-6 w-full min-w-0">
        
        <!-- Aktivitas Terbaru -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm w-full">
            <h3 class="text-xs md:text-sm font-bold text-gray-800 mb-4">Aktivitas & Log Terbaru</h3>
            <div class="space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $documents->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex gap-3">
                    <?php if($log->status == 'verified'): ?>
                        <div class="w-5 h-5 md:w-6 md:h-6 bg-green-50 text-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
                    <?php elseif($log->status == 'pending'): ?>
                        <div class="w-5 h-5 md:w-6 md:h-6 bg-yellow-50 text-yellow-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                    <?php else: ?>
                        <div class="w-5 h-5 md:w-6 md:h-6 bg-red-50 text-red-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5"><svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></div>
                    <?php endif; ?>
                    
                    <div class="min-w-0">
                        <p class="text-[11px] md:text-[12px] text-gray-800 leading-snug break-words">
                            <span class="font-bold"><?php echo e($log->type->name); ?></span> 
                            <?php if($log->status == 'verified'): ?> telah diverifikasi
                            <?php elseif($log->status == 'pending'): ?> berhasil diunggah
                            <?php else: ?> ditolak, perlu diperbaiki
                            <?php endif; ?>
                        </p>
                        <p class="text-[9px] md:text-[10px] text-gray-400 mt-1"><?php echo e($log->uploaded_at ? $log->uploaded_at->diffForHumans() : '-'); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-[11px] md:text-xs text-gray-500 italic">Belum ada aktivitas.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kontak Bantuan -->
        <div class="bg-white border border-gray-200 rounded-xl p-4 md:p-5 shadow-sm w-full">
            <h3 class="text-xs md:text-sm font-bold text-gray-800 mb-4">Kontak Bantuan</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center font-bold text-xs shrink-0">
                    <?php echo e(substr($waliKelas->name ?? 'WK', 0, 2)); ?>

                </div>
                <div class="min-w-0">
                    <p class="text-xs md:text-sm font-bold text-gray-800 truncate"><?php echo e($waliKelas->name ?? 'Data Wali Kelas Kosong'); ?></p>
                    <p class="text-[10px] md:text-[11px] text-gray-500">Wali Kelas • <?php echo e($siswa->classRoom->name ?? '-'); ?></p>
                </div>
            </div>
            <a href="https://wa.me/<?php echo e($waliKelas->no_hp ?? '6281234567890'); ?>?text=Halo%20Bu%20<?php echo e(urlencode($waliKelas->name ?? 'Wali Kelas')); ?>%2C%20saya%20<?php echo e(urlencode($siswa->name)); ?>%20ingin%20berkonsultasi." target="_blank" class="w-full block bg-[#10b981] hover:bg-green-600 text-white text-[11px] md:text-xs font-bold py-2 rounded-lg transition text-center">
                Hubungi via WhatsApp
            </a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.siswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>
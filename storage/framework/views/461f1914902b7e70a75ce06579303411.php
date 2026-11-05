

<?php $__env->startSection('title', 'Antrean Verifikasi Berkas'); ?>

<?php $__env->startSection('content'); ?>
<!-- Notifikasi Sukses/Error -->
<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Antrean Verifikasi Berkas</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar dokumen siswa yang menunggu pengecekan</p>
    </div>
    <div class="bg-yellow-100 text-yellow-700 text-xs font-bold px-4 py-2 rounded-lg border border-yellow-200 w-max">
        <?php echo e($documents->count()); ?> Berkas Pending
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-bold">Siswa</th>
                    <th class="px-6 py-4 font-bold">Jenis Dokumen</th>
                    <th class="px-6 py-4 font-bold">Tanggal Unggahan</th>
                    <th class="px-6 py-4 font-bold">Status</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800"><?php echo e($doc->student->name); ?></p>
                        <p class="text-[11px] text-gray-500">NIS: <?php echo e($doc->student->nis); ?> | <?php echo e($doc->student->classRoom->name ?? '-'); ?></p>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium"><?php echo e($doc->type->name); ?></td>
                    <td class="px-6 py-4 text-gray-500"><?php echo e($doc->uploaded_at ? $doc->uploaded_at->format('d M Y') : '-'); ?></td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-700 text-[11px] font-bold px-3 py-1 rounded-full">Pending</span>
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end items-center gap-2">
                        <!-- Tombol Lihat File (Memanggil Modal) -->
                        <button type="button" onclick="bukaPreview('<?php echo e(asset('storage/' . $doc->file_path)); ?>', '<?php echo e($doc->type->name); ?> - <?php echo e($doc->student->name); ?>')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold px-3 py-2 rounded-lg transition border border-gray-200">
                            Lihat File
                        </button>

                        <!-- Tombol Setujui -->
                        <form action="<?php echo e(route('admin.verifikasi.approve', $doc->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="bg-[#10b981] hover:bg-green-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">Setujui</button>
                        </form>

                        <!-- Tombol Tolak (Memanggil Modal Custom) -->
                        <button type="button" onclick="konfirmasiTolak(<?php echo e($doc->id); ?>, '<?php echo e($doc->student->name); ?>', '<?php echo e($doc->type->name); ?>')" class="bg-[#ef4444] hover:bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
                            Tolak
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-base font-medium text-gray-600">Semua Berkas Sudah Diverifikasi</p>
                            <p class="text-xs mt-1">Tidak ada antrean dokumen yang menunggu pengecekan.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL PREVIEW FILE (Diperbesar 95vw x 95vh) -->
<div id="modalPreview" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.9); z-index: 10000; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-[95vw] h-[95vh] flex flex-col" style="margin: auto; position: relative;">
        <!-- Header Modal -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-gray-50 rounded-t-2xl">
            <h3 class="text-lg font-bold text-gray-800 truncate" id="previewTitle">Preview Dokumen</h3>
            <button onclick="document.getElementById('modalPreview').style.display = 'none'; document.getElementById('previewIframe').src = '';" class="text-gray-400 hover:text-red-500 bg-white border border-gray-200 p-2 rounded-lg transition shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Body Modal (Isi File) -->
        <div class="flex-1 bg-gray-100 p-2 overflow-hidden rounded-b-2xl">
            <iframe id="previewIframe" src="" class="w-full h-full rounded-lg border-0 shadow-inner bg-white"></iframe>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI TOLAK CUSTOM -->
<div id="modalTolak" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6" style="margin: auto; position: relative;">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-4 mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Tolak Dokumen?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">
            Apakah Anda yakin ingin menolak dokumen <b id="jenisDokumenTolak" class="text-gray-800"></b> milik <b id="namaSiswaTolak" class="text-gray-800"></b>? Siswa harus mengunggah ulang dokumen ini.
        </p>
        
        <form id="formTolak" method="POST">
            <?php echo csrf_field(); ?>
            <div class="flex justify-center gap-3">
                <button type="button" onclick="document.getElementById('modalTolak').style.display = 'none'" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition">Ya, Tolak</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan Preview File di dalam Modal
    function bukaPreview(url, title) {
        document.getElementById('previewTitle').innerText = title;
        document.getElementById('previewIframe').src = url;
        document.getElementById('modalPreview').style.display = 'flex';
    }

    // Fungsi untuk menutup modal preview ketika area luar diklik
    document.getElementById('modalPreview').addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            document.getElementById('previewIframe').src = '';
        }
    });

    function konfirmasiTolak(id, namaSiswa, jenisDokumen) {
        document.getElementById('namaSiswaTolak').innerText = namaSiswa;
        document.getElementById('jenisDokumenTolak').innerText = jenisDokumen;
        document.getElementById('formTolak').action = '/admin/verifikasi/' + id + '/reject';
        document.getElementById('modalTolak').style.display = 'flex';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/admin/verifikasi.blade.php ENDPATH**/ ?>
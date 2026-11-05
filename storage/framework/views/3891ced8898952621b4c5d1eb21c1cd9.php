

<?php $__env->startSection('title', 'Upload Dokumen Kolektif (ZIP / Excel)'); ?>

<?php $__env->startSection('content'); ?>
<!-- Notifikasi -->
<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm font-medium border border-red-200">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    
    <!-- Area Upload -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Area Unggah File</h3>
        
        <form action="<?php echo e(route('admin.upload-kolektif.proses')); ?>" method="POST" enctype="multipart/form-data" id="form-upload">
            <?php echo csrf_field(); ?>
            <div class="border-2 border-dashed border-blue-200 bg-blue-50/30 rounded-xl flex flex-col items-center justify-center py-12 px-4 text-center transition relative" id="drop-area">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-700 mb-1">Tarik & lepas file ZIP berkas siswa di sini</p>
                <p class="text-xs text-gray-500 mb-4">Maksimal ukuran file 50MB</p>
                
                <!-- Input File Tersembunyi -->
                <input type="file" name="file_zip" id="file_zip" class="hidden" accept=".zip" required onchange="tampilkanFile()">
                
                <!-- Tombol Pilih File -->
                <button type="button" id="btn-pilih" onclick="document.getElementById('file_zip').click()" class="bg-[#4F46E5] hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition">Pilih File ZIP</button>
                
                <!-- Info File Terpilih (Tersembunyi Awal) -->
                <div id="info-file" class="hidden flex flex-col items-center mt-4">
                    <p class="text-xs text-green-600 font-bold mb-3" id="file-name"></p>
                    <button type="submit" class="bg-gray-900 hover:bg-black text-white text-sm font-bold px-6 py-2 rounded-lg transition shadow-md">Mulai Proses Upload</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Petunjuk Upload -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Petunjuk Upload</h3>
        <ul class="space-y-3 text-sm text-gray-600 mb-6">
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Gunakan format berkas <b>.ZIP</b> berisi banyak PDF sekaligus.</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span><b>PENTING:</b> Nama file di dalam ZIP wajib diawali NIS siswa (Cth: <code>240123_Raport.pdf</code>).</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Ukuran file maksimum 50 MB per proses unggah.</span>
            </li>
        </ul>
    </div>
</div>

<!-- Riwayat Upload -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-5 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Riwayat Upload Terakhir</h3>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100">
                <th class="px-6 py-3 font-bold">Tanggal & Waktu</th>
                <th class="px-6 py-3 font-bold">Nama File</th>
                <th class="px-6 py-3 font-bold">Jumlah Data</th>
                <th class="px-6 py-3 font-bold">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 text-sm">
            <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 text-gray-600"><?php echo e($history->created_at->format('d M Y, H:i')); ?></td>
                <td class="px-6 py-4 font-bold text-gray-800"><?php echo e($history->file_name); ?></td>
                <td class="px-6 py-4 text-gray-600"><?php echo e($history->total_data); ?> Berkas</td>
                <td class="px-6 py-4">
                    <?php if($history->status == 'Sukses'): ?>
                        <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1 rounded-full">Sukses</span>
                    <?php else: ?>
                        <span class="bg-red-100 text-red-700 text-[11px] font-bold px-3 py-1 rounded-full"><?php echo e($history->status); ?></span>
                    <?php endif; ?>
                    <p class="text-[10px] text-gray-400 mt-1"><?php echo e($history->keterangan); ?></p>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada riwayat upload.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function tampilkanFile() {
        const input = document.getElementById('file_zip');
        const infoDiv = document.getElementById('info-file');
        const fileNameText = document.getElementById('file-name');
        const btnPilih = document.getElementById('btn-pilih');
        const dropArea = document.getElementById('drop-area');

        if (input.files.length > 0) {
            // Tampilkan nama file dan tombol submit
            fileNameText.innerText = "File terpilih: " + input.files[0].name;
            infoDiv.classList.remove('hidden');
            
            // Sembunyikan tombol pilih awal & ubah warna border
            btnPilih.classList.add('hidden');
            dropArea.classList.add('border-green-400', 'bg-green-50/30');
            dropArea.classList.remove('border-blue-200', 'bg-blue-50/30');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/admin/upload_kolektif.blade.php ENDPATH**/ ?>
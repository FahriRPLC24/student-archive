

<?php $__env->startSection('title', 'Kelola Kelas & Jurusan'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Kelola Kelas & Jurusan</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola struktur kelas, jurusan, dan pantau kelengkapan berkas tiap rombel.</p>
    </div>
    <button onclick="document.getElementById('modalKelas').style.display = 'flex'" class="bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-sm px-4 py-2 font-medium flex items-center gap-2 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kelas Baru
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900"><?php echo e($class->name); ?></h3>
                <p class="text-[12px] text-gray-500"><?php echo e($class->major); ?></p>
            </div>
            <span class="bg-blue-50 text-blue-600 text-[11px] font-bold px-2 py-1 rounded"><?php echo e($class->students_count ?? 0); ?> Siswa</span>
        </div>
        
        <div class="mb-5">
            <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5">
                <span>Progress Kelengkapan</span>
                <span class="<?php echo e($class->persen_kelengkapan >= 80 ? 'text-green-500' : ($class->persen_kelengkapan >= 50 ? 'text-blue-500' : 'text-orange-500')); ?>">
                    <?php echo e($class->persen_kelengkapan); ?>%
                </span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <div class="<?php echo e($class->persen_kelengkapan >= 80 ? 'bg-[#10b981]' : ($class->persen_kelengkapan >= 50 ? 'bg-blue-500' : 'bg-[#f59e0b]')); ?> h-2 rounded-full transition-all duration-500" style="width: <?php echo e($class->persen_kelengkapan); ?>%"></div>
            </div>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="flex gap-2">
            <!-- Tombol Hapus -->
            <button type="button" onclick="konfirmasiHapusKelas(<?php echo e($class->id); ?>, '<?php echo e($class->name); ?>')" class="w-12 border border-red-200 text-red-500 rounded-lg text-sm py-2 font-medium hover:bg-red-50 transition flex items-center justify-center" title="Hapus Kelas">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
            
            <!-- Tombol Edit -->
            <button onclick="bukaModalEdit(<?php echo e($class->id); ?>, '<?php echo e($class->name); ?>', '<?php echo e($class->grade); ?>', '<?php echo e($class->major); ?>')" class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 rounded-lg text-sm py-2 font-medium flex items-center justify-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit
            </button>

            <!-- Tombol Detail (Daftar Siswa) -->
            <button onclick="bukaModalDetailSiswa(<?php echo e($class->id); ?>, '<?php echo e($class->name); ?>')" class="flex-1 bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-sm py-2 font-medium flex items-center justify-center gap-1 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Detail
            </button>
        </div>

        <!-- Hidden Data Siswa untuk Modal Detail (Disimpan dalam format JSON) -->
        <script>
            window['siswa_kelas_<?php echo e($class->id); ?>'] = <?php echo json_encode($class->students, 15, 512) ?>;
        </script>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-span-3 text-center text-gray-500 py-10 bg-white rounded-xl border border-gray-200">
        Belum ada data kelas. Silakan tambah kelas baru.
    </div>
    <?php endif; ?>
</div>

<!-- ================= MODAL TAMBAH KELAS ================= -->
<div id="modalKelas" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Tambah Kelas Baru</h3>
            <button onclick="document.getElementById('modalKelas').style.display = 'none'" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="<?php echo e(route('admin.kelas.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Kelas (Cth: XII RPL A)</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Tingkat (Cth: XII)</label>
                <input type="text" name="grade" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Jurusan (Cth: RPL)</label>
                <input type="text" name="major" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalKelas').style.display = 'none'" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT KELAS ================= -->
<div id="modalEdit" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Edit Data Kelas</h3>
            <button onclick="document.getElementById('modalEdit').style.display = 'none'" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditKelas" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Kelas</label>
                <input type="text" name="name" id="edit_name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Tingkat</label>
                <input type="text" name="grade" id="edit_grade" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Jurusan</label>
                <input type="text" name="major" id="edit_major" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalEdit').style.display = 'none'" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL DETAIL SISWA ================= -->
<div id="modalDetailSiswa" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 max-h-[90vh] flex flex-col" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-4 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900" id="judulDetailSiswa">Daftar Siswa</h3>
            <button onclick="document.getElementById('modalDetailSiswa').style.display = 'none'" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <!-- Area Tabel Siswa (Bisa di-scroll) -->
        <div class="flex-1 overflow-y-auto pr-1">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-white">
                    <tr class="text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-200">
                        <th class="py-2 font-bold w-12 text-center">No</th>
                        <th class="py-2 font-bold">Nama Siswa</th>
                        <th class="py-2 font-bold">NIS</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100" id="listSiswaContainer">
                    <!-- Diisi oleh JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL KONFIRMASI HAPUS KELAS ================= -->
<div id="modalHapusKelas" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6" style="margin: auto; position: relative;">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-4 mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Hapus Kelas?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Apakah Anda yakin ingin menghapus kelas <b id="namaHapusKelas"></b>? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="formHapusKelas" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="flex justify-center gap-3">
                <button type="button" onclick="document.getElementById('modalHapusKelas').style.display = 'none'" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi Modal Edit
    function bukaModalEdit(id, name, grade, major) {
        document.getElementById('modalEdit').style.display = 'flex';
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_grade').value = grade;
        document.getElementById('edit_major').value = major;
        document.getElementById('formEditKelas').action = '/admin/kelas/' + id;
    }

    // Fungsi Modal Detail Siswa
    function bukaModalDetailSiswa(classId, className) {
        document.getElementById('judulDetailSiswa').innerText = 'Daftar Siswa ' + className;
        document.getElementById('modalDetailSiswa').style.display = 'flex';
        
        const container = document.getElementById('listSiswaContainer');
        container.innerHTML = ''; // Kosongkan tabel dulu

        // Ambil data siswa dari script tersembunyi yang kita buat tadi
        const dataSiswa = window['siswa_kelas_' + classId];

        if (dataSiswa && dataSiswa.length > 0) {
            dataSiswa.forEach((siswa, index) => {
                let row = `
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 text-center font-medium text-gray-500">${index + 1}</td>
                        <td class="py-3 font-bold text-gray-800">${siswa.name}</td>
                        <td class="py-3 text-gray-500">${siswa.nis}</td>
                    </tr>
                `;
                container.innerHTML += row;
            });
        } else {
            container.innerHTML = `<tr><td colspan="3" class="py-4 text-center text-gray-500">Belum ada data siswa di kelas ini.</td></tr>`;
        }
    }

    // Fungsi Hapus Kelas
    function konfirmasiHapusKelas(id, nama) {
        document.getElementById('namaHapusKelas').innerText = nama;
        document.getElementById('formHapusKelas').action = '/admin/kelas/' + id;
        document.getElementById('modalHapusKelas').style.display = 'flex';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/admin/kelas.blade.php ENDPATH**/ ?>
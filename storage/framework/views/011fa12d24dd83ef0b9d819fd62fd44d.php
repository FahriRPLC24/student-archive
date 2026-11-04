

<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm font-medium border border-red-200">
        <?php echo e($errors->first()); ?>

    </div>
<?php endif; ?>

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Manajemen Pengguna</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola akun Kurikulum, Guru, dan Siswa.</p>
    </div>
    <button onclick="document.getElementById('modalUser').style.display = 'flex'" class="bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-sm px-4 py-2 font-medium flex items-center justify-center gap-2 shadow-sm w-full sm:w-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Pengguna
    </button>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100">
                    <th class="px-6 py-4 font-bold">Nama Pengguna</th>
                    <th class="px-6 py-4 font-bold">Role</th>
                    <th class="px-6 py-4 font-bold">NIS / NIP</th>
                    <th class="px-6 py-4 font-bold">Kelas</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800"><?php echo e($user->name); ?></p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                            <?php echo e($user->role == 'admin' ? 'bg-purple-100 text-purple-700' : ''); ?>

                            <?php echo e($user->role == 'guru' ? 'bg-blue-100 text-blue-700' : ''); ?>

                            <?php echo e($user->role == 'siswa' ? 'bg-green-100 text-green-700' : ''); ?>">
                            <?php echo e($user->role); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($user->nis ?? $user->nip ?? '-'); ?></td>
                    <td class="px-6 py-4 text-gray-600"><?php echo e($user->classRoom->name ?? '-'); ?></td>
                    
                    <td class="px-6 py-4 text-right">
                        <!-- Tombol Hapus yang memicu modal custom -->
                        <button type="button" onclick="konfirmasiHapus(<?php echo e($user->id); ?>, '<?php echo e($user->name); ?>')" class="text-red-500 hover:text-red-700 font-bold text-xs bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition border border-red-100">
                            Hapus
                        </button>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH USER -->
<div id="modalUser" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Tambah Pengguna Baru</h3>
            <button onclick="document.getElementById('modalUser').style.display = 'none'" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="<?php echo e(route('admin.users.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Role / Hak Akses</label>
                    <select name="role" id="roleSelect" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" onchange="toggleFields()">
                        <option value="siswa">Siswa</option>
                        <option value="guru">Guru</option>
                        <option value="admin">Kurikulum</option>
                    </select>
                </div>
            </div>

            <div id="fieldEmailPassword" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4 hidden">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Email (Opsional)</label>
                    <input type="email" name="email" id="inputEmail" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="admin@sekolah.id">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Password</label>
                    <input type="password" name="password" id="inputPassword" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Min. 6 karakter">
                </div>
            </div>

            <div id="fieldSiswa" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">NIS</label>
                    <input type="text" name="nis" id="inputNis" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="inputTanggalLahir" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Kelas</label>
                    <select name="class_id" id="inputClass" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">-- Pilih Kelas --</option>
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($class->id); ?>"><?php echo e($class->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div id="fieldGuru" class="mb-4 hidden">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">NIP</label>
                <input type="text" name="nip" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Masukkan NIP">
            </div>

            <div class="flex justify-end gap-2 mt-8 pt-4 border-t border-gray-100">
                <button type="button" onclick="document.getElementById('modalUser').style.display = 'none'" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI HAPUS CUSTOM -->
<div id="modalHapus" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6" style="margin: auto; position: relative;">
        <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-4 mx-auto">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Hapus Pengguna?</h3>
        <p class="text-sm text-gray-500 text-center mb-6">Apakah Anda yakin ingin menghapus <b id="namaHapus"></b>? Tindakan ini tidak dapat dibatalkan.</p>
        
        <form id="formHapus" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <div class="flex justify-center gap-3">
                <button type="button" onclick="document.getElementById('modalHapus').style.display = 'none'" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md transition">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFields() {
        const role = document.getElementById('roleSelect').value;
        const fieldEmailPassword = document.getElementById('fieldEmailPassword');
        const fieldSiswa = document.getElementById('fieldSiswa');
        const fieldGuru = document.getElementById('fieldGuru');

        if (role === 'siswa') {
            fieldEmailPassword.classList.add('hidden');
            fieldSiswa.classList.remove('hidden');
            fieldGuru.classList.add('hidden');
        } else if (role === 'guru') {
            fieldEmailPassword.classList.remove('hidden');
            fieldSiswa.classList.add('hidden');
            fieldGuru.classList.remove('hidden');
        } else {
            fieldEmailPassword.classList.remove('hidden');
            fieldSiswa.classList.add('hidden');
            fieldGuru.classList.add('hidden');
        }
    }
    document.addEventListener('DOMContentLoaded', toggleFields);

    // Fungsi untuk memunculkan modal hapus custom
    function konfirmasiHapus(id, nama) {
        document.getElementById('namaHapus').innerText = nama;
        document.getElementById('formHapus').action = '/admin/users/' + id;
        document.getElementById('modalHapus').style.display = 'flex';
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ASM1\student-archive\resources\views/admin/users.blade.php ENDPATH**/ ?>
@extends('layouts.admin')

@section('title', 'Kelola Kelas & Jurusan')

@section('content')
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Kelola Kelas & Jurusan</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola struktur kelas, jurusan, dan pantau kelengkapan berkas tiap rombel.</p>
    </div>
    <button onclick="bukaModalTambah()" class="bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-sm px-4 py-2 font-medium flex items-center gap-2 shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Tambah Kelas Baru
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($classes as $class)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $class->name }}</h3>
                <p class="text-[12px] text-gray-500">{{ $class->major }}</p>
            </div>
            <span class="bg-blue-50 text-blue-600 text-[11px] font-bold px-2 py-1 rounded">{{ $class->students_count ?? 0 }} Siswa</span>
        </div>
        
        <div class="mb-5">
            <div class="flex justify-between text-xs font-bold text-gray-700 mb-1.5">
                <span>Progress Kelengkapan</span>
                <!-- Menampilkan persentase asli dari DB -->
                <span class="{{ $class->persen_kelengkapan >= 80 ? 'text-green-500' : ($class->persen_kelengkapan >= 50 ? 'text-blue-500' : 'text-orange-500') }}">
                    {{ $class->persen_kelengkapan }}%
                </span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
                <!-- Progress bar dinamis -->
                <div class="{{ $class->persen_kelengkapan >= 80 ? 'bg-[#10b981]' : ($class->persen_kelengkapan >= 50 ? 'bg-blue-500' : 'bg-[#f59e0b]') }} h-2 rounded-full transition-all duration-500" style="width: {{ $class->persen_kelengkapan }}%"></div>
            </div>
        </div>

        <div class="flex gap-2">
            <form action="{{ route('admin.kelas.destroy', $class->id) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full border border-red-200 text-red-500 rounded-lg text-sm py-2 font-medium hover:bg-red-50 transition" onclick="return confirm('Hapus kelas ini?')">
                    Hapus
                </button>
            </form>
            
            <button onclick="bukaModalEdit({{ $class->id }}, '{{ $class->name }}', '{{ $class->grade }}', '{{ $class->major }}')" class="flex-1 bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-sm py-2 font-medium flex items-center justify-center gap-1 shadow-sm">
                Detail
            </button>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center text-gray-500 py-10 bg-white rounded-xl border border-gray-200">
        Belum ada data kelas. Silakan tambah kelas baru.
    </div>
    @endforelse
</div>

<!-- MODAL TAMBAH KELAS -->
<div id="modalTambah" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Tambah Kelas Baru</h3>
            <button onclick="tutupModalTambah()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
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
                <button type="button" onclick="tutupModalTambah()" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT KELAS (DETAIL) -->
<div id="modalEdit" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Detail & Edit Kelas</h3>
            <button onclick="tutupModalEdit()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="formEditKelas" method="POST">
            @csrf
            @method('PUT')
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
                <button type="button" onclick="tutupModalEdit()" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModalTambah() {
        document.getElementById('modalTambah').style.display = 'flex';
    }
    function tutupModalTambah() {
        document.getElementById('modalTambah').style.display = 'none';
    }

    function bukaModalEdit(id, name, grade, major) {
        document.getElementById('modalEdit').style.display = 'flex';
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_grade').value = grade;
        document.getElementById('edit_major').value = major;
        document.getElementById('formEditKelas').action = '/admin/kelas/' + id;
    }
    function tutupModalEdit() {
        document.getElementById('modalEdit').style.display = 'none';
    }
</script>
@endsection
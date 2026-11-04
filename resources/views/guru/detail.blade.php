@extends('layouts.guru')

@section('title', 'Detail Dokumen')

@section('content')
<div class="mb-4">
    <a href="{{ route('guru.dokumen') }}" class="text-xs text-blue-600 hover:underline mb-2 inline-block">&larr; Kembali ke Data Siswa</a>
    <h2 class="text-xl font-bold text-gray-800">Detail Dokumen</h2>
    <p class="text-sm text-gray-500 mt-1">Rincian kelengkapan berkas per siswa.</p>
</div>

<!-- Notifikasi -->
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm font-medium border border-red-200">
        {{ $errors->first() }}
    </div>
@endif

<!-- Kartu Siswa -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 mb-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center font-bold">
            {{ substr($siswa->name, 0, 2) }}
        </div>
        <div>
            <h3 class="font-bold text-gray-800">{{ $siswa->name }}</h3>
            <p class="text-[11px] text-gray-500">NIS: {{ $siswa->nis }} · {{ $siswa->classRoom->name ?? '-' }}</p>
        </div>
    </div>
</div>

<!-- List Dokumen Dinamis -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="font-bold text-gray-800 text-sm">Dokumen Akademik</h3>
            <p class="text-[11px] text-gray-500 mt-0.5">Kelola status dan berkas siswa.</p>
        </div>
        <!-- Tombol Trigger Modal Upload -->
        <button onclick="bukaModalUpload()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm">
            + Upload Dokumen Baru
        </button>
    </div>
    
    <div class="divide-y divide-gray-100 text-xs">
        @foreach($documentTypes as $type)
            @php
                $doc = $siswa->documents->where('document_type_id', $type->id)->first();
            @endphp
            <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                <span class="font-medium text-gray-700 w-1/3">{{ $type->name }}</span>
                
                <div class="w-32">
                    @if($doc)
                        @if($doc->status == 'verified')
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-[10px] font-bold">● Terverifikasi</span>
                        @elseif($doc->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-[10px] font-bold">● Menunggu</span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-[10px] font-bold">● Ditolak</span>
                        @endif
                    @else
                        <span class="bg-gray-100 text-gray-500 px-2 py-1 rounded text-[10px] font-bold">● Belum Ada</span>
                    @endif
                </div>

                <div class="w-1/3 text-right space-x-3 flex justify-end items-center">
                    @if($doc)
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat</a>
                        
                        <form action="{{ route('guru.destroy-document', $doc->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus dokumen ini?')">Hapus</button>
                        </form>
                    @else
                        <span class="text-gray-400 italic">Belum diunggah</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- MODAL UPLOAD DOKUMEN -->
<!-- KUNCINYA ADA DI style="..." DI BAWAH INI AGAR PASTI DI TENGAH -->
<div id="modalUpload" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center mb-5 border-b pb-3">
            <h3 class="text-lg font-bold text-gray-900">Upload Dokumen</h3>
            <button onclick="tutupModalUpload()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('guru.store-document') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="student_id" value="{{ $siswa->id }}">

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">Pilih Jenis Dokumen</label>
                <select name="document_type_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($documentTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-1.5">File Dokumen (PDF/JPG/PNG)</label>
                <input type="file" name="file" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                <p class="text-[10px] text-gray-500 mt-1">Maksimal ukuran file: 5MB.</p>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
                <button type="button" onclick="tutupModalUpload()" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition">Upload Sekarang</button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT -->
<script>
    function bukaModalUpload() {
        document.getElementById('modalUpload').style.display = 'flex';
    }

    function tutupModalUpload() {
        document.getElementById('modalUpload').style.display = 'none';
    }
</script>
@endsection
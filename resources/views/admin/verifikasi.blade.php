@extends('layouts.admin')

@section('title', 'Antrean Verifikasi Berkas')

@section('content')
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm font-medium border border-green-200">
        {{ session('success') }}
    </div>
@endif

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Antrean Verifikasi Berkas</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar dokumen siswa yang menunggu pengecekan</p>
    </div>
    <div class="bg-yellow-100 text-yellow-700 text-xs font-bold px-4 py-2 rounded-lg border border-yellow-200 w-max">
        {{ $documents->count() }} Berkas Pending
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
    <!-- BUNGKUS TABEL DENGAN OVERFLOW-X-AUTO -->
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
                @forelse($documents as $doc)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-bold text-gray-800">{{ $doc->student->name }}</p>
                        <p class="text-[11px] text-gray-500">NIS: {{ $doc->student->nis }} | {{ $doc->student->classRoom->name ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-medium">{{ $doc->type->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $doc->uploaded_at ? $doc->uploaded_at->format('d M Y') : '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-700 text-[11px] font-bold px-3 py-1 rounded-full">Pending</span>
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end items-center gap-2">
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold px-3 py-2 rounded-lg transition border border-gray-200">
                            Lihat File
                        </a>
                        <form action="{{ route('admin.verifikasi.approve', $doc->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[#10b981] hover:bg-green-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition">Setujui</button>
                        </form>
                        <form action="{{ route('admin.verifikasi.reject', $doc->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-[#ef4444] hover:bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-lg transition" onclick="return confirm('Tolak dokumen ini?')">Tolak</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <p class="text-base font-medium text-gray-600">Semua Berkas Sudah Diverifikasi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
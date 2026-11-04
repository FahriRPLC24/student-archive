@extends('layouts.guru')

@section('title', 'Data & Dokumen')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Data & Dokumen Siswa</h2>
    <p class="text-sm text-gray-500 mt-1">Kelola berkas akademik untuk kelas <b>{{ $kelasDiampu->name ?? '-' }}</b>.</p>
</div>

<div class="bg-white p-3 rounded-t-xl border border-gray-200 border-b-0 flex flex-col sm:flex-row gap-2 items-start sm:items-center justify-between">
    <form action="{{ route('guru.dokumen') }}" method="GET" class="relative w-full sm:w-72 flex gap-2">
        <div class="relative w-full">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIS..." class="w-full pl-9 pr-3 py-1.5 border border-gray-200 rounded text-xs focus:outline-none focus:border-blue-500">
        </div>
        <button type="submit" class="bg-gray-100 hover:bg-gray-200 border border-gray-200 rounded px-3 py-1.5 text-xs font-bold text-gray-700 transition">Cari</button>
    </form>
</div>

<div class="bg-white border border-gray-200 rounded-b-xl shadow-sm overflow-hidden flex flex-col">
    <!-- BUNGKUS TABEL -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="text-[10px] text-gray-400 uppercase tracking-wider border-b border-gray-100">
                    <th class="px-4 py-3 font-bold">SISWA</th>
                    <th class="px-4 py-3 font-bold">NIS</th>
                    <th class="px-4 py-3 font-bold">KELAS</th>
                    <th class="px-4 py-3 font-bold">KELENGKAPAN</th>
                    <th class="px-4 py-3 font-bold text-right">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs">
                @forelse($siswas as $siswa)
                    @php
                        $totalWajib = 7; 
                        $terverifikasi = $siswa->documents->where('status', 'verified')->count();
                        $persen = round(($terverifikasi / $totalWajib) * 100);
                        $warna = $persen == 100 ? 'green' : ($persen > 50 ? 'orange' : 'red');
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-bold text-gray-800">{{ $siswa->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $siswa->nis ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $siswa->classRoom->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-{{ $warna }}-100 text-{{ $warna }}-600 px-2 py-0.5 rounded text-[10px] font-bold">
                                ● {{ $persen }}%
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('guru.detail', $siswa->id) }}" class="text-blue-600 font-medium hover:underline">Kelola Berkas</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data siswa di kelas ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
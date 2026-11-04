@extends('layouts.guru')

@section('title', 'Laporan')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Laporan</h2>
        <p class="text-sm text-gray-500 mt-1">Rekapitulasi kelengkapan dokumen untuk kelas <b>{{ $kelasDiampu->name ?? '-' }}</b>.</p>
    </div>
    <div class="flex gap-2">
        <select class="border border-gray-200 rounded text-xs px-3 py-1.5 bg-white focus:outline-none">
            <option>2025/2026</option>
        </select>
        
        <!-- Tombol PDF Berfungsi -->
        <a href="{{ route('guru.laporan.export-pdf') }}" class="bg-white border border-gray-300 rounded text-xs px-4 py-1.5 font-bold text-gray-700 hover:bg-gray-50 flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            PDF
        </a>
    </div>
</div>

<!-- 4 Card Statistik Dinamis -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">SISWA TERDATA</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $totalSiswa }}</h3>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">DOKUMEN</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $totalDokumen }}</h3>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">LENGKAP</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $persenLengkap }}%</h3>
    </div>
    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
        <p class="text-[11px] text-gray-500 mb-1">BELUM LENGKAP</p>
        <h3 class="text-2xl font-bold text-gray-800">{{ $persenBelumLengkap }}%</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Kelengkapan per Kelas -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <h3 class="text-sm font-bold text-gray-800 mb-5">Kelengkapan per Kelas</h3>
        <div class="space-y-4">
            @foreach($rekapKelas as $rekap)
            <div>
                <div class="flex justify-between text-[11px] font-bold text-gray-700 mb-1">
                    <span>{{ $rekap['name'] }}</span>
                    <span>{{ $rekap['persen'] }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $rekap['persen'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Rekap Jenis Dokumen -->
    <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
        <h3 class="text-sm font-bold text-gray-800 mb-5">Rekap Jenis Dokumen</h3>
        <div class="space-y-4">
            @foreach($rekapJenis as $jenis)
            <div>
                <div class="flex justify-between text-[11px] font-bold text-gray-700 mb-1">
                    <span>{{ $jenis['name'] }}</span>
                    <span>{{ $jenis['persen'] }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="{{ $jenis['persen'] == 100 ? 'bg-green-500' : 'bg-blue-600' }} h-1.5 rounded-full" style="width: {{ $jenis['persen'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="mt-6 flex gap-2">
    <!-- Tombol Cetak Rekap (Trigger Print Browser) -->
    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Cetak Rekap
    </button>
</div>
@endsection
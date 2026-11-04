@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6">
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative">
        <p class="text-[11px] text-gray-500 uppercase font-bold mb-1">Total Siswa</p>
        <h3 class="text-3xl font-bold text-[#0B1527]">{{ $totalSiswa }}</h3>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
    <div class="p-4 border-b border-gray-100 flex flex-col md:flex-row gap-3 items-start md:items-center justify-between">
        <form action="{{ route('admin.siswa') }}" method="GET" class="flex flex-col sm:flex-row gap-2 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau NIS..." class="w-full pl-4 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            </div>
            <select name="class_id" class="border border-gray-200 rounded-lg text-sm px-3 py-2 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                <option value="">Semua Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 text-white text-sm px-4 py-2 rounded-lg hover:bg-gray-900 w-full sm:w-auto">Filter</button>
        </form>

        <a href="{{ route('admin.siswa.export-pdf') }}" class="bg-white border border-gray-300 rounded-lg text-sm px-4 py-2 font-medium hover:bg-gray-50 flex items-center justify-center gap-2 text-gray-700 shadow-sm w-full md:w-auto">
            Export PDF
        </a>
    </div>

    <!-- KUNCINYA: overflow-x-auto dan min-w-[700px] -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[700px]">
            <thead>
                <tr class="text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100 bg-gray-50">
                    <th class="px-6 py-4 font-bold">Siswa</th>
                    <th class="px-6 py-4 font-bold">NIS</th>
                    <th class="px-6 py-4 font-bold">Kelas</th>
                    <th class="px-6 py-4 font-bold">Progres Berkas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($siswas as $siswa)
                    @php
                        $totalWajib = 11; 
                        $terverifikasi = $siswa->documents->where('status', 'verified')->count();
                        $persen = round(($terverifikasi / $totalWajib) * 100);
                        $warna = $persen == 100 ? 'green' : ($persen > 50 ? 'orange' : 'red');
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-bold text-gray-800">{{ $siswa->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $siswa->nis }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $siswa->classRoom->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-24 bg-gray-100 rounded-full h-1.5"><div class="bg-{{ $warna }}-500 h-1.5 rounded-full" style="width: {{ $persen }}%"></div></div>
                                <span class="text-xs font-bold text-{{ $warna }}-500">{{ $terverifikasi }}/{{ $totalWajib }} ({{ $persen }}%)</span>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Data siswa tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
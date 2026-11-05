@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6">
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative">
        <p class="text-[11px] text-gray-500 uppercase font-bold mb-1">Total Siswa</p>
        <h3 class="text-3xl font-bold text-[#0B1527]">{{ $totalSiswa }}</h3>
        <div class="absolute right-4 top-4 text-blue-500 bg-blue-50 p-2 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
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
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export PDF
        </a>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="text-gray-500 text-[11px] uppercase tracking-wider border-b border-gray-100 bg-gray-50">
                    <th class="px-6 py-4 font-bold">Siswa</th>
                    <th class="px-6 py-4 font-bold">NIS</th>
                    <th class="px-6 py-4 font-bold">Kelas</th>
                    <th class="px-6 py-4 font-bold">Progres Berkas</th>
                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
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
                        <td class="px-6 py-4 text-right">
                            <button type="button" onclick='bukaDetailSiswa(@json($siswa))' class="text-blue-600 font-medium hover:underline text-xs bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">
                                Lihat Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Data siswa tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ================= MODAL DETAIL SISWA ================= -->
<div id="modalDetail" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.8); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl p-6 max-h-[90vh] flex flex-col" style="margin: auto; position: relative;">
        
        <div class="flex justify-between items-start mb-5 border-b pb-4">
            <div>
                <h3 class="text-xl font-bold text-gray-900" id="modalNamaSiswa">Nama Siswa</h3>
                <p class="text-sm text-gray-500 mt-1" id="modalNisSiswa">NIS: - | Kelas: -</p>
            </div>
            <button onclick="document.getElementById('modalDetail').style.display = 'none'" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-lg transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto pr-2 space-y-3" id="modalListDokumen">
            <!-- Diisi oleh JavaScript -->
        </div>
    </div>
</div>

<!-- ================= MODAL PREVIEW FILE ================= -->
<div id="modalPreview" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(17, 24, 39, 0.9); z-index: 10000; align-items: center; justify-content: center; backdrop-filter: blur(4px); padding: 1rem;">
    <div class="bg-white rounded-2xl shadow-2xl w-[95vw] h-[95vh] flex flex-col" style="margin: auto; position: relative;">
        <div class="flex justify-between items-center p-4 border-b border-gray-200 bg-gray-50 rounded-t-2xl">
            <h3 class="text-lg font-bold text-gray-800 truncate" id="previewTitle">Preview Dokumen</h3>
            <button onclick="tutupPreview()" class="text-gray-400 hover:text-red-500 bg-white border border-gray-200 p-2 rounded-lg transition shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="flex-1 bg-gray-100 p-2 overflow-hidden rounded-b-2xl">
            <iframe id="previewIframe" src="" class="w-full h-full rounded-lg border-0 shadow-inner bg-white"></iframe>
        </div>
    </div>
</div>

<script>
    function bukaDetailSiswa(siswa) {
        // 1. Tampilkan Modal Detail
        document.getElementById('modalDetail').style.display = 'flex';
        
        // 2. Isi Header
        document.getElementById('modalNamaSiswa').innerText = siswa.name;
        document.getElementById('modalNisSiswa').innerText = 'NIS: ' + (siswa.nis || '-') + ' | Kelas: ' + (siswa.class_room ? siswa.class_room.name : '-');

        // 3. Render List Dokumen
        const container = document.getElementById('modalListDokumen');
        container.innerHTML = ''; 

        const uploadedDocs = siswa.documents || [];

        for (let i = 1; i <= 11; i++) {
            let doc = uploadedDocs.find(d => d.document_type_id === i);
            
            let statusBadge = '';
            let actionBtn = '';

            if (doc) {
                if (doc.status === 'verified') {
                    statusBadge = '<span class="bg-green-100 text-green-700 text-[10px] font-bold px-3 py-1 rounded-full">✓ Terverifikasi</span>';
                } else if (doc.status === 'pending') {
                    statusBadge = '<span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-3 py-1 rounded-full">⏳ Menunggu</span>';
                } else {
                    statusBadge = '<span class="bg-red-100 text-red-700 text-[10px] font-bold px-3 py-1 rounded-full">✕ Ditolak</span>';
                }
                
                // TOMBOL LIHAT FILE MEMANGGIL MODAL PREVIEW
                actionBtn = `<button type="button" onclick="bukaPreview('${doc.file_path}', '${siswa.name}')" class="text-blue-600 hover:text-blue-800 hover:underline text-xs font-bold bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">Lihat File</button>`;
            } else {
                statusBadge = '<span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full">Belum Ada</span>';
                actionBtn = '<span class="text-gray-400 text-xs italic">-</span>';
            }

            const docNames = [
                "Raport Semester 1", "Raport Semester 2", "Raport Semester 3", 
                "Raport Semester 4", "Raport Semester 5", "Raport Semester 6", 
                "Sertifikat TOEIC", "Sertifikat TKA", "Sertifikat UKK", 
                "Sertifikat PKL", "Ijazah"
            ];
            let docName = docNames[i - 1];

            let row = `
                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-800">${docName}</p>
                    </div>
                    <div class="w-32 text-center">
                        ${statusBadge}
                    </div>
                    <div class="w-24 text-right">
                        ${actionBtn}
                    </div>
                </div>
            `;
            container.innerHTML += row;
        }
    }

    // Fungsi Preview File
    function bukaPreview(path, siswaName) {
        document.getElementById('previewTitle').innerText = 'Dokumen - ' + siswaName;
        // Path dari JS tidak mengandung '/storage/', jadi kita tambahkan manual
        document.getElementById('previewIframe').src = '/storage/' + path;
        document.getElementById('modalPreview').style.display = 'flex';
    }

    function tutupPreview() {
        document.getElementById('modalPreview').style.display = 'none';
        document.getElementById('previewIframe').src = ''; 
    }

    // Menutup preview jika klik di luar kotak putih
    document.getElementById('modalPreview').addEventListener('click', function(e) {
        if (e.target === this) {
            tutupPreview();
        }
    });
</script>
@endsection
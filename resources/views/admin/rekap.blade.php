@extends('layouts.admin')

@section('title', 'Rekapitulasi Kelengkapan Berkas')

@section('content')
<!-- Header Card & Tombol Responsif -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <div>
            <h2 class="text-lg md:text-xl font-bold text-gray-800">Rekapitulasi Kelengkapan Berkas</h2>
            <p class="text-xs md:text-sm text-gray-500 mt-1">Ringkasan persentase kelengkapan dokumen siswa per kelas.</p>
        </div>
        
        <!-- Tombol Cetak & PDF (Responsif) -->
        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <button onclick="window.print()" class="w-full sm:w-auto border border-gray-300 rounded-lg text-xs md:text-sm px-4 py-2.5 font-medium hover:bg-gray-50 flex items-center justify-center gap-2 text-gray-700 bg-white shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak
            </button>
            <a href="{{ route('admin.siswa.export-pdf') }}" class="w-full sm:w-auto bg-[#4F46E5] hover:bg-blue-700 text-white rounded-lg text-xs md:text-sm px-4 py-2.5 font-medium flex items-center justify-center gap-2 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download PDF Report
            </a>
        </div>
    </div>
</div>

<!-- Grid Layout: Chart & Progress Bar -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- KIRI: Progress Bar per Kelas -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h4 class="text-xs font-bold text-gray-700 mb-6 uppercase tracking-wide">Persentase Kelengkapan Per Kelas</h4>
        
        <div class="space-y-6">
            @foreach($rekapKelas as $rekap)
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-medium text-gray-700">{{ $rekap['name'] }} ({{ $rekap['siswa'] }} Siswa)</span>
                    <span class="font-bold text-gray-900">{{ $rekap['persen'] }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3">
                    <div class="h-3 rounded-full {{ $rekap['persen'] >= 80 ? 'bg-[#10b981]' : ($rekap['persen'] >= 50 ? 'bg-[#4F46E5]' : 'bg-[#f59e0b]') }}" style="width: {{ $rekap['persen'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-sm text-gray-500 mt-8 pt-6 border-t border-gray-100">
            Menampilkan ringkasan kelengkapan dari {{ array_sum(array_column($rekapKelas, 'siswa')) }} siswa di seluruh kelas.
        </div>
    </div>

    <!-- KANAN: Pie Chart (Nilai Tambah Multimedia) -->
    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col items-center">
        <h4 class="text-xs font-bold text-gray-700 mb-6 uppercase tracking-wide text-center">Diagram Kelengkapan</h4>
        
        <!-- Kanvas untuk Chart.js -->
        <div class="w-full max-w-[250px] relative">
            <canvas id="myChart"></canvas>
        </div>
        
        <!-- Legenda Manual -->
        <div class="w-full mt-6 space-y-3">
            @foreach($rekapKelas as $index => $rekap)
            <div class="flex justify-between items-center text-xs">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full" id="legend-{{ $index }}"></div>
                    <span class="font-medium text-gray-600">{{ $rekap['name'] }}</span>
                </div>
                <span class="font-bold text-gray-800">{{ $rekap['persen'] }}%</span>
            </div>
            @endforeach
        </div>
    </div>

</div>

<!-- SCRIPT CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('myChart').getContext('2d');
        
        // Ambil data dari PHP
        const labels = {!! json_encode(array_column($rekapKelas, 'name')) !!};
        const dataValues = {!! json_encode(array_column($rekapKelas, 'persen')) !!};
        
        // Warna Chart
        const backgroundColors = [
            'rgba(79, 70, 229, 0.8)',  // Indigo
            'rgba(16, 185, 129, 0.8)', // Emerald
            'rgba(245, 158, 11, 0.8)'  // Amber
        ];
        
        const borderColors = [
            'rgba(79, 70, 229, 1)',
            'rgba(16, 185, 129, 1)',
            'rgba(245, 158, 11, 1)'
        ];

        // Set Warna Legenda Manual
        labels.forEach((label, index) => {
            const legendDiv = document.getElementById('legend-' + index);
            if (legendDiv) {
                legendDiv.style.backgroundColor = borderColors[index % borderColors.length];
            }
        });

        // Konfigurasi Chart
        new Chart(ctx, {
            type: 'doughnut', // Tipe chart: donat/pie
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda bawaan Chart.js karena kita buat manual di HTML
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                },
                cutout: '65%' // Ketebalan donat (semakin besar persen, semakin tipis)
            }
        });
    });
</script>
@endsection
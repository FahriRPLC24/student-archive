<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kelengkapan Siswa</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        p.subtitle { text-align: center; margin-top: 0; color: #555; }
    </style>
</head>
<body>
    <h2>Laporan Rekapitulasi Kelengkapan Dokumen Siswa</h2>
    <p class="subtitle">Kelas: {{ $kelasDiampu->name ?? '-' }} | SMK Negeri 5 Surakarta</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Berkas Terverifikasi</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $index => $siswa)
            @php
                $totalWajib = 7;
                $verified = $siswa->documents->where('status', 'verified')->count();
                $persen = round(($verified / $totalWajib) * 100);
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $verified }} / {{ $totalWajib }}</td>
                <td>{{ $persen }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada data siswa di kelas ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
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
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Rekapitulasi Kelengkapan Dokumen Siswa</h2>
    <p>SMK Negeri 5 Surakarta - Program Studi RPL</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Berkas Terverifikasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $index => $siswa)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $siswa->name }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->classRoom->name ?? '-' }}</td>
                <td>{{ $siswa->documents->where('status', 'verified')->count() }} / 7</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
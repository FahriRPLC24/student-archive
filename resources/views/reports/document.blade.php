<h2>Laporan Dokumen Akademik</h2>
<table border="1" width="100%" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Jenis Dokumen</th>
            <th>Status</th>
            <th>Tanggal Upload</th>
        </tr>
    </thead>
    <tbody>
        @foreach($documents as $i => $doc)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $doc->student->name }}</td>
            <td>{{ $doc->type->name }}</td>
            <td>{{ ucfirst($doc->status) }}</td>
            <td>{{ $doc->uploaded_at?->format('d/m/Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
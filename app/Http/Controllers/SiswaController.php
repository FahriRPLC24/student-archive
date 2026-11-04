<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentType;
use App\Models\Document;
use App\Models\ClassRoom; 
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard(Request $request) // Tambah Request $request
    {
        $siswa = Auth::user();
        $search = $request->input('search'); // Ambil input search

        // 1. Ambil data kelas dan Wali Kelas
        $kelasSiswa = ClassRoom::with('teacher')->find($siswa->class_id);
        $waliKelas = $kelasSiswa ? $kelasSiswa->teacher : null;

        // 2. Ambil semua jenis dokumen wajib
        $allTypes = DocumentType::where('is_required', true)->get();
        $totalWajib = $allTypes->count();

        // 3. Ambil dokumen milik siswa ini (Dengan Filter Search)
        $query = Document::with('type')->where('student_id', $siswa->id);

        if ($search) {
            $query->whereHas('type', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->get();

        // 4. Hitung kelengkapan (berdasarkan semua dokumen, bukan hasil search)
        $allDocs = Document::where('student_id', $siswa->id)->get();
        $terverifikasi = $allDocs->where('status', 'verified')->count();
        $persen = $totalWajib > 0 ? round(($terverifikasi / $totalWajib) * 100) : 0;

        // 5. Ambil 4 dokumen terbaru (untuk card)
        $recentDocuments = $documents->take(4);

        // 6. Cari dokumen yang belum diupload
        $uploadedTypeIds = $allDocs->pluck('document_type_id')->toArray();
        $missingTypes = $allTypes->whereNotIn('id', $uploadedTypeIds);

        return view('siswa.dashboard', compact(
            'siswa', 
            'documents', 
            'recentDocuments', 
            'persen', 
            'terverifikasi', 
            'totalWajib',
            'missingTypes',
            'waliKelas',
            'search' // Kirim variabel search ke view
        ));
    }
}
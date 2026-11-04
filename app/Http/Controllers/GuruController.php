<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class GuruController extends Controller
{
    // 1. Dashboard Guru
    public function dashboard()
    {
        $guru = Auth::user();
        $kelasDiampu = ClassRoom::where('teacher_id', $guru->id)->first();
        $classId = $kelasDiampu ? $kelasDiampu->id : null;

        $totalSiswa = User::where('role', 'siswa')->when($classId, function ($q) use ($classId) { $q->where('class_id', $classId); })->count();
        $totalDokumen = Document::whereHas('student', function ($q) use ($classId) { $q->where('class_id', $classId); })->count();
        $perluUpdate = Document::whereHas('student', function ($q) use ($classId) { $q->where('class_id', $classId); })->where('status', 'pending')->count();

        $totalWajib = DocumentType::where('is_required', true)->count() * $totalSiswa;
        $terverifikasi = Document::whereHas('student', function ($q) use ($classId) { $q->where('class_id', $classId); })->where('status', 'verified')->count();
        $persenKelengkapan = $totalWajib > 0 ? round(($terverifikasi / $totalWajib) * 100) : 0;

        $perluPerhatian = Document::with(['student', 'type'])
            ->whereHas('student', function ($q) use ($classId) { $q->where('class_id', $classId); })
            ->whereIn('status', ['pending', 'rejected'])->latest()->take(5)->get();

        $rekapKelas = [];
        if ($kelasDiampu) { $rekapKelas[] = ['name' => $kelasDiampu->name, 'persen' => $persenKelengkapan]; }

        return view('guru.dashboard', compact('kelasDiampu', 'totalSiswa', 'totalDokumen', 'perluUpdate', 'persenKelengkapan', 'perluPerhatian', 'rekapKelas'));
    }

    // 2. Daftar Siswa
    public function dokumen(Request $request)
    {
        $guru = Auth::user();
        $kelasDiampu = ClassRoom::where('teacher_id', $guru->id)->first();
        $classId = $kelasDiampu ? $kelasDiampu->id : null;
        $search = $request->input('search');
        
        // Ambil data siswa berdasarkan ID Kelas yang diampu
        $siswas = User::where('role', 'siswa')
            ->where('class_id', $classId) // Filter Kelas
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('nis', 'like', "%{$search}%");
            })
            ->with(['classRoom', 'documents'])
            ->get();

        return view('guru.dokumen', compact('siswas', 'search', 'kelasDiampu'));
    }

    // 3. Detail Dokumen
    public function detail($id)
    {
        $siswa = User::with(['classRoom', 'documents.type'])->findOrFail($id);
        $guru = Auth::user();
        $kelasDiampu = ClassRoom::where('teacher_id', $guru->id)->first();
        
        if ($kelasDiampu && $siswa->class_id !== $kelasDiampu->id) { 
            abort(403, 'Akses ditolak.'); 
        }

        // Urutkan jenis dokumen dari id terkecil (Raport 1-6)
        $documentTypes = DocumentType::orderBy('id', 'asc')->get();

        return view('guru.detail', compact('siswa', 'documentTypes'));
    }

    // 4. Upload Dokumen
    public function storeDocument(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'document_type_id' => 'required|exists:document_types,id',
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $existingDoc = Document::where('student_id', $request->student_id)->where('document_type_id', $request->document_type_id)->first();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('documents', $fileName, 'public');

            if ($existingDoc) {
                Storage::disk('public')->delete($existingDoc->file_path);
                $existingDoc->update(['file_name' => $file->getClientOriginalName(), 'file_path' => $path, 'uploaded_by' => Auth::id(), 'status' => 'pending', 'uploaded_at' => now()]);
            } else {
                Document::create(['student_id' => $request->student_id, 'document_type_id' => $request->document_type_id, 'uploaded_by' => Auth::id(), 'file_name' => $file->getClientOriginalName(), 'file_path' => $path, 'status' => 'pending', 'uploaded_at' => now()]);
            }
        }
        return redirect()->route('guru.detail', $request->student_id)->with('success', 'Dokumen berhasil diunggah.');
    }

    // 5. Hapus Dokumen
    public function destroyDocument($id)
    {
        $doc = Document::findOrFail($id);
        Storage::disk('public')->delete($doc->file_path);
        $doc->delete();
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
    }

    // 6. Laporan Guru
    public function laporan()
    {
        $guru = Auth::user();
        $kelasDiampu = ClassRoom::where('teacher_id', $guru->id)->first();
        $classId = $kelasDiampu ? $kelasDiampu->id : null;

        $totalSiswa = User::where('role', 'siswa')->where('class_id', $classId)->count();
        $totalDokumen = Document::whereHas('student', function($q) use ($classId) { $q->where('class_id', $classId); })->count();

        $totalWajib = DocumentType::where('is_required', true)->count() * $totalSiswa;
        $terverifikasi = Document::whereHas('student', function($q) use ($classId) { $q->where('class_id', $classId); })->where('status', 'verified')->count();
        
        $persenLengkap = $totalWajib > 0 ? round(($terverifikasi / $totalWajib) * 100) : 0;
        $persenBelumLengkap = 100 - $persenLengkap;

        $rekapKelas = [];
        if ($kelasDiampu) { $rekapKelas[] = ['name' => $kelasDiampu->name, 'persen' => $persenLengkap]; }

        $documentTypes = DocumentType::where('is_required', true)->get();
        $rekapJenis = [];
        foreach ($documentTypes as $type) {
            $verifiedCount = Document::where('document_type_id', $type->id)->whereHas('student', function($q) use ($classId) { $q->where('class_id', $classId); })->where('status', 'verified')->count();
            $rekapJenis[] = ['name' => $type->name, 'persen' => $totalSiswa > 0 ? round(($verifiedCount / $totalSiswa) * 100) : 0];
        }

        return view('guru.laporan', compact('kelasDiampu', 'totalSiswa', 'totalDokumen', 'persenLengkap', 'persenBelumLengkap', 'rekapKelas', 'rekapJenis'));
    }

    // 7. Export PDF
    public function exportPdf()
    {
        $guru = Auth::user();
        $kelasDiampu = ClassRoom::where('teacher_id', $guru->id)->first();
        $classId = $kelasDiampu ? $kelasDiampu->id : null;

        $siswas = User::where('role', 'siswa')->where('class_id', $classId)->with(['classRoom', 'documents'])->get();

        $pdf = Pdf::loadView('guru.pdf_laporan', compact('siswas', 'kelasDiampu'));
        return $pdf->download('Laporan_Kelengkapan_' . ($kelasDiampu->name ?? 'Kelas') . '.pdf');
    }
}
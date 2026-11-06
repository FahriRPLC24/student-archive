<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassRoom;
use App\Models\DocumentType;
use App\Models\User;
use App\Models\Document;
use App\Models\UploadHistory;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

class AdminController extends Controller
{
    // ================= DASHBOARD =================
    public function dashboard()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalGuru = User::where('role', 'guru')->count();
        $totalDokumen = Document::count();
        $perluVerifikasi = Document::where('status', 'pending')->count();
        
        $totalWajib = DocumentType::where('is_required', true)->count() * $totalSiswa;
        $terverifikasi = Document::where('status', 'verified')->count();
        $persenKelengkapan = $totalWajib > 0 ? round(($terverifikasi / $totalWajib) * 100) : 0;

        return view('admin.dashboard', compact('totalSiswa', 'totalGuru', 'totalDokumen', 'perluVerifikasi', 'persenKelengkapan'));
    }

    // ================= DATA SISWA =================
    public function siswa(Request $request)
    {
        $search = $request->input('search');
        $classId = $request->input('class_id');
        $query = User::where('role', 'siswa')->with(['classRoom', 'documents']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('nis', 'like', "%{$search}%");
            });
        }
        if ($classId) { $query->where('class_id', $classId); }

        $siswas = $query->get();
        $totalSiswa = User::where('role', 'siswa')->count(); 
        $classes = ClassRoom::all();

        return view('admin.siswa', compact('siswas', 'classes', 'search', 'classId', 'totalSiswa'));
    }

    public function exportPdf()
    {
        $siswas = User::where('role', 'siswa')->with(['classRoom', 'documents'])->get();
        $pdf = Pdf::loadView('admin.pdf_rekap', compact('siswas'));
        return $pdf->download('rekap_kelengkapan_siswa.pdf');
    }

    // ================= VERIFIKASI =================
    public function verifikasi()
    {
        $documents = Document::with(['student', 'type', 'uploader'])
            ->where('status', 'pending')->latest()->get();
        return view('admin.verifikasi', compact('documents'));
    }

    public function approveDocument($id)
    {
        Document::findOrFail($id)->update(['status' => 'verified']);
        return redirect()->back()->with('success', 'Dokumen berhasil disetujui.');
    }

    public function rejectDocument($id)
    {
        Document::findOrFail($id)->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Dokumen berhasil ditolak.');
    }

    // ================= KELAS =================
    public function kelas()
    {
        $totalDocTypes = DocumentType::where('is_required', true)->count();

        // Ambil kelas beserta jumlah siswanya, DAN data siswanya (diurutkan A-Z)
        $classes = ClassRoom::withCount(['students' => function ($query) {
            $query->where('role', 'siswa');
        }])->with(['students' => function($query) {
            $query->where('role', 'siswa')->orderBy('name', 'asc');
        }])->get();

        foreach ($classes as $class) {
            $jumlahSiswa = $class->students_count;
            $totalWajibKelas = $jumlahSiswa * $totalDocTypes;
            
            $docVerified = Document::whereHas('student', function($q) use ($class) {
                $q->where('class_id', $class->id);
            })->where('status', 'verified')->count();

            $class->persen_kelengkapan = $totalWajibKelas > 0 ? round(($docVerified / $totalWajibKelas) * 100) : 0;
        }

        return view('admin.kelas', compact('classes'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate(['name' => 'required', 'grade' => 'required', 'major' => 'required']);
        ClassRoom::create($request->all());
        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function updateKelas(Request $request, $id)
    {
        $request->validate(['name' => 'required', 'grade' => 'required', 'major' => 'required']);
        ClassRoom::findOrFail($id)->update($request->all());
        return redirect()->back()->with('success', 'Data Kelas berhasil diperbarui!');
    }

    public function destroyKelas($id)
    {
        ClassRoom::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kelas berhasil dihapus!');
    }

    // ================= DOC TYPES =================
    public function documentTypes()
    {
        $types = DocumentType::all();
        return view('admin.document_types', compact('types'));
    }

    public function storeDocumentType(Request $request)
    {
        $request->validate(['name' => 'required', 'code' => 'required|unique:document_types']);
        DocumentType::create(['name' => $request->name, 'code' => $request->code, 'is_required' => $request->has('is_required')]);
        return redirect()->back()->with('success', 'Jenis Dokumen berhasil ditambahkan!');
    }

    // ================= USERS =================
    public function users(Request $request)
    {
        $search = $request->input('search');

        $query = User::with('classRoom');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $users = $query->get();
        $classes = ClassRoom::all();
        
        return view('admin.users', compact('users', 'classes', 'search'));
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users',
            'password' => 'nullable|min:6',
            'role' => 'required|in:admin,guru,siswa',
            'nis' => 'nullable|string|unique:users',
            'nip' => 'nullable|string|unique:users',
            'tanggal_lahir' => 'nullable|date', // Validasi input tanggal lahir
            'class_id' => 'nullable|exists:classes,id',
        ]);
        

        // Cek password untuk Admin/Guru
        if ($request->role !== 'siswa' && (empty($request->email) || empty($request->password))) {
            return redirect()->back()->withErrors(['email' => 'Email dan Password wajib diisi untuk Kurikulum/Guru.']);
        }

        // LOGIKA PENYIMPANAN
        $data = [
            'name' => $request->name,
            'email' => $request->role === 'siswa' ? null : $request->email,
            'password' => $request->role === 'siswa' ? Hash::make('password123') : Hash::make($request->password),
            'role' => $request->role,
            'class_id' => $request->class_id,
        ];

        // Jika Siswa: NIS disimpan, Tanggal Lahir disimpan ke kolom NIP
        if ($request->role === 'siswa') {
            $data['nis'] = $request->nis;
            $data['nip'] = $request->tanggal_lahir; 
        } else {
            // Jika Guru/Admin: NIP disimpan
            $data['nip'] = $request->nip;
        }

        $user = User::create($data);
        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'User berhasil ditambahkan!');
    }
    // TAMBAHKAN METHOD INI UNTUK MENGHAPUS DOKUMEN DARI PANEL ADMIN
    public function destroyDocument($id)
    {
        $doc = Document::findOrFail($id);
        
        // Hapus file fisik dari storage
        \Storage::disk('public')->delete($doc->file_path);
        
        // Hapus data dari database
        $doc->delete();

        return redirect()->back()->with('success', 'Dokumen berhasil dihapus dari sistem.');
    }
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        // Keamanan: Cegah Admin menghapus akunnya sendiri yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan.']);
        }

        // Hapus user
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }

    // ================= UPLOAD KOLEKTIF =================
    public function uploadKolektif()
    {
        $histories = UploadHistory::latest()->take(10)->get();
        return view('admin.upload_kolektif', compact('histories'));
    }

    public function prosesUploadKolektif(Request $request)
    {
        $request->validate(['file_zip' => 'required|mimes:zip|max:51200']);

        if ($request->hasFile('file_zip')) {
            $file = $request->file('file_zip');
            $tmpPath = $file->getRealPath();
            $tempZipPath = sys_get_temp_dir() . '/' . time() . '_' . $file->getClientOriginalName();

            if (copy($tmpPath, $tempZipPath)) {
                chmod($tempZipPath, 0777);
                $zip = new \ZipArchive;
                $res = $zip->open($tempZipPath);

                if ($res === TRUE) {
                    $berhasil = 0; $gagal = 0;

                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $filename = $zip->getNameIndex($i);
                        if (substr($filename, -1) == '/') continue;

                        preg_match('/^(\d{6})/', basename($filename), $matches);
                        
                        if (isset($matches[1])) {
                            $nis = $matches[1];
                            $siswa = User::where('nis', $nis)->where('role', 'siswa')->first();

                            if ($siswa) {
                                $docType = DocumentType::where('code', 'like', '%' . strtolower(pathinfo($filename, PATHINFO_FILENAME)) . '%')->first() ?? DocumentType::first(); 
                                $fileContent = $zip->getFromIndex($i);
                                $newFileName = time() . '_' . $nis . '_' . basename($filename);
                                \Storage::disk('public')->put('documents/' . $newFileName, $fileContent);

                                Document::updateOrCreate(
                                    ['student_id' => $siswa->id, 'document_type_id' => $docType->id],
                                    [
                                        'uploaded_by' => auth()->id(),
                                        'file_name' => basename($filename),
                                        'file_path' => 'documents/' . $newFileName,
                                        'status' => 'verified', 
                                        'uploaded_at' => now(),
                                    ]
                                );
                                $berhasil++;
                            } else { $gagal++; }
                        }
                    }
                    $zip->close();
                    unlink($tempZipPath);

                    UploadHistory::create([
                        'file_name' => $file->getClientOriginalName(),
                        'type' => 'zip',
                        'total_data' => $berhasil,
                        'status' => $berhasil > 0 ? 'Sukses' : 'Gagal',
                        'keterangan' => "Berhasil: $berhasil file. Gagal (NIS tak cocok): $gagal file. (Otomatis Verified)."
                    ]);

                    return redirect()->back()->with('success', "Proses Selesai! $berhasil file berhasil dimasukkan dan otomatis terverifikasi.");
                } else {
                    return redirect()->back()->with('error', "Gagal membuka file ZIP. Kode Error PHP: " . $res);
                }
            } else {
                return redirect()->back()->with('error', "Gagal memindahkan file ke temporary sistem.");
            }
        }
    }

    // ================= REKAP =================
    public function rekap()
    {
        $totalDocTypes = DocumentType::where('is_required', true)->count();
        $classes = ClassRoom::withCount(['students' => function ($query) {
            $query->where('role', 'siswa');
        }])->get();

        $rekapKelas = [];
        foreach ($classes as $class) {
            $jumlahSiswa = $class->students_count;
            $totalWajibKelas = $jumlahSiswa * $totalDocTypes;
            $docVerified = Document::whereHas('student', function($q) use ($class) {
                $q->where('class_id', $class->id);
            })->where('status', 'verified')->count();

            $persen = $totalWajibKelas > 0 ? round(($docVerified / $totalWajibKelas) * 100) : 0;
            $rekapKelas[] = ['name' => $class->name, 'siswa' => $jumlahSiswa, 'persen' => $persen];
        }
        return view('admin.rekap', compact('rekapKelas', 'totalDocTypes'));
    }
}
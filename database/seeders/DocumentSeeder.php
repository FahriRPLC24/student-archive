<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentType;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = User::where('role', 'siswa')->first();
        $guru = User::where('role', 'guru')->first();
        $type = DocumentType::first();

        if ($siswa && $guru && $type) {
            Document::create([
                'student_id' => $siswa->id,
                'document_type_id' => $type->id,
                'uploaded_by' => $guru->id,
                'file_name' => 'Raport_Semester_1.pdf',
                'file_path' => 'documents/dummy.pdf',
                'status' => 'verified',
                'uploaded_at' => now(),
            ]);
        }
    }
}
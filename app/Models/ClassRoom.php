<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    protected $table = 'classes'; 

    protected $fillable = ['name', 'grade', 'major', 'teacher_id'];

    // Relasi ke Siswa
    public function students()
    {
        return $this->hasMany(User::class, 'class_id')->where('role', 'siswa');
    }

    // Relasi ke Wali Kelas (Guru)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
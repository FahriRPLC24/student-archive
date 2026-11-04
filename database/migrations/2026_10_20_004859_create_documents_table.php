<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('document_type_id')->constrained('document_types')->cascadeOnDelete();
        $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete(); // Guru/Admin
        $table->string('file_name');
        $table->string('file_path');
        $table->string('status')->default('pending'); // pending, verified, rejected
        $table->timestamp('uploaded_at')->nullable();
        $table->timestamps();
    });
}
};

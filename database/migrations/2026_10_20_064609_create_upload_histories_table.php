<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upload_histories', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('type'); // 'zip' atau 'excel'
            $table->integer('total_data')->default(0);
            $table->string('status'); // 'Sukses', 'Gagal'
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upload_histories');
    }
};
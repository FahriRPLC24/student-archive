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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nis')) {
                $table->string('nis')->nullable()->unique()->after('email');
            }
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->unique()->after('nis');
            }
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('siswa')->after('nip'); // admin, guru, siswa
            }
            if (!Schema::hasColumn('users', 'class_id')) {
                $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['class_id']);
            $table->dropColumn(['nis', 'nip', 'role', 'class_id']);
        });
    }
};

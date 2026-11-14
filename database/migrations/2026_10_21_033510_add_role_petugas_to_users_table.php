<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi: ubah atau tambahkan kolom role dengan enum admin, petugas, siswa
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika kolom role sudah ada, kita ubah definisinya
            // Jika belum ada, kolom akan dibuat otomatis
            if (Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'petugas', 'siswa'])
                      ->default('siswa')
                      ->change();
            } else {
                $table->enum('role', ['admin', 'petugas', 'siswa'])
                      ->default('siswa')
                      ->after('password');
            }
        });
    }

    /**
     * Membalikkan migrasi jika terjadi rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'siswa'])
                      ->default('siswa')
                      ->change();
            }
        });
    }
};
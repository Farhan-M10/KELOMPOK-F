<?php
// File: database/migrations/2025_12_20_041129_add_jenis_to_kategoris_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('kategoris', 'jenis')) {
            Schema::table('kategoris', function (Blueprint $table) {
                $table->enum('jenis', ['medis', 'non-medis'])->default('medis')->after('nama_kategori');
            });
            
            DB::table('kategoris')->update(['jenis' => 'medis']);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kategoris', 'jenis')) {
            Schema::table('kategoris', function (Blueprint $table) {
                $table->dropColumn('jenis');
            });
        }
    }
};
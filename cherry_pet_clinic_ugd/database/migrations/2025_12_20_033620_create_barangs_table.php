<?php
// File: database/migrations/2025_12_20_033620_create_barangs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->foreignId('jenis_barang_id')->constrained('jenis_barangs')->onDelete('restrict');
            $table->string('lokasi');
            $table->string('ruangan');
            $table->integer('total_stok')->default(0);
            $table->string('satuan');
            $table->integer('stok_minimum')->default(10);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
<?php
// File: database/migrations/2025_12_20_033652_create_batch_barangs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('nomor_batch');
            $table->date('tanggal_masuk');
            $table->date('tanggal_kadaluarsa');
            $table->integer('jumlah');
            $table->enum('status', ['Stok Aman', 'Perhatian', 'Kritis'])->default('Stok Aman');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_barangs');
    }
};
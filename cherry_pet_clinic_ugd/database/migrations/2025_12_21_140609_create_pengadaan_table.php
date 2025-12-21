<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengadaan_stok', function (Blueprint $table) {
            $table->id(); // Auto increment untuk relasi
            $table->string('id_pengadaan')->unique(); // ID custom untuk display
            $table->date('tanggal');
            $table->foreignId('suppliers_id')->constrained('suppliers')->onDelete('restrict');
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->enum('status', ['Disetujui', 'Menunggu', 'Ditolak'])->default('Menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('detail_pengadaan_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengadaan_stok_id')->constrained('pengadaan_stok')->onDelete('cascade');
            $table->foreignId('barangs_id')->constrained('barangs')->onDelete('restrict');
            $table->integer('jumlah_pesan');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_pengadaan_stok');
        Schema::dropIfExists('pengadaan_stok');
    }
};
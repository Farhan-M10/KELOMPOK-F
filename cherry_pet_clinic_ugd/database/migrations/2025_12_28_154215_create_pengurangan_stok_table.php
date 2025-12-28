<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengurangan_stok', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_barang_id')->constrained('batch_barangs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah_pengurangan');
            $table->string('alasan');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pengurangan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengurangan_stok');
    }
};

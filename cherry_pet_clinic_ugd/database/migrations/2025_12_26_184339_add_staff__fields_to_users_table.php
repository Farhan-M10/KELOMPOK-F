<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
   {
       Schema::table('users', function (Blueprint $table) {
           // Hanya tambahkan kolom yang BELUM ada
           if (!Schema::hasColumn('users', 'phone')) {
               $table->string('phone')->nullable();
           }
           if (!Schema::hasColumn('users', 'status')) {
               $table->enum('status', ['active', 'inactive'])->default('active');
           }
           if (!Schema::hasColumn('users', 'address')) {
               $table->text('address')->nullable();
           }
           if (!Schema::hasColumn('users', 'remember_token')) {
               $table->string('remember_token', 100)->nullable();
           }
           // JANGAN tambahkan 'role' karena sudah ada
       });
}

   public function down()
   {
       Schema::table('users', function (Blueprint $table) {
           $table->dropColumn(['phone', 'role', 'status', 'address', 'remember_token']);
       });
   }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('laporan_stok', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->date('tanggal_cetak');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_stok');
    }
};

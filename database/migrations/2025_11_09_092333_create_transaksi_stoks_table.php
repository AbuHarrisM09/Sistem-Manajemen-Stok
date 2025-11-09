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
        Schema::create('transaksi_stok', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_bahan')->constrained('bahan', 'id_bahan')->onDelete('cascade');
            $table->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('jumlah_bahan');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi_stok');
    }
};

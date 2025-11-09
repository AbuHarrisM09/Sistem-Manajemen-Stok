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
        Schema::create('bahan', function (Blueprint $table) {
            $table->id('id_bahan');
            $table->string('nama_bahan')->unique();
            $table->string('satuan'); // kg, pcs, liter
            $table->integer('stok_minimum')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bahan');
    }
};

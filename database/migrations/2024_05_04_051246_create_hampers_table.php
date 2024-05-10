<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hampers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk1');
            $table->unsignedBigInteger('id_produk2');
            $table->foreign('id_produk1')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('id_produk2')->references('id')->on('produks')->onDelete('cascade');
            $table->string('nama');
            $table->string('rincian');
            $table->float('harga');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hampers');
    }
};

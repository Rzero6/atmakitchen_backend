<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_penitip')->nullable();
            $table->foreign('id_penitip')->references('id')->on('penitips')->onDelete('cascade');
            $table->integer('stok');
            $table->string('nama');
            $table->float('harga');
            $table->string('jenis');
            $table->string('ukuran');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};

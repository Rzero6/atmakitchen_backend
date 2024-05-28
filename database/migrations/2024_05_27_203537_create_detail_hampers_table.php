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
        Schema::create('detail_hampers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_hampers')->constrained('detail_hampers', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->unsignedBigInteger('id_bahan_baku')->nullable();
            $table->foreign('id_produk')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('id_bahan_baku')->references('id')->on('bahan_bakus')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_hampers');
    }
};

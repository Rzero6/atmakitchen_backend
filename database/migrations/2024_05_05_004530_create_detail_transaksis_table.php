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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi')->constrained('transaksis', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->foreign('id_produk')->references('id')->on('produks')->onDelete('cascade');
            $table->unsignedBigInteger('id_hampers')->nullable();
            $table->foreign('id_hampers')->references('id')->on('hampers')->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};

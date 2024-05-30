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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->constrained('customers', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('id_alamat')->nullable();
            $table->foreign('id_alamat')->references('id')->on('alamats')->onDelete('cascade');
            $table->dateTime('tanggal_penerimaan');
            $table->string('status');
            $table->integer('jarak');
            $table->float('tip');
            $table->float('total_harga');
            $table->string('bukti_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

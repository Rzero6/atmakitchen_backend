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
            $table->foreignId('id_alamat')->constrained('alamats', 'id')->onDelete('cascade');
            $table->timestamp('tanggal_penerimaan');
            $table->string('status');
            $table->integer('jarak');
            $table->float('tip');
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

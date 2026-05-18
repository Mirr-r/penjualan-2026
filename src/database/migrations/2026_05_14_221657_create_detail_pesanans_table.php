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
    Schema::create('detail_pesanans', function (Blueprint $table) {
        $table->id();

        $table->foreignId('pemesanan_id')
            ->constrained('pemesanans')
            ->cascadeOnDelete();

        $table->foreignId('produk_id')
            ->constrained('produks')
            ->cascadeOnDelete();

        $table->integer('qty');

        $table->decimal('harga', 12, 2);

        $table->decimal('subtotal', 12, 2);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};

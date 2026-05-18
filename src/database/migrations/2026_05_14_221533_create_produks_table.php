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

        $table->foreignId('kategori_id')
            ->constrained('kategoris')
            ->cascadeOnDelete();

        $table->string('nama');

        $table->string('slug')->unique();

        $table->text('deskripsi')->nullable();

        $table->decimal('harga', 12, 2);

        $table->integer('stok')->default(0);

        $table->string('ukuran')->nullable();

        $table->string('merk')->nullable();

        $table->string('gambar')->nullable();

        $table->boolean('is_active')->default(true);

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

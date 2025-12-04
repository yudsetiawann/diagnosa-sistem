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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            // Siapa pasiennya? (User)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Apa hasil diagnosanya? (Bisa null jika belum ketemu)
            $table->foreignId('disease_id')->nullable()->constrained()->onDelete('set null');

            // Simpan gejala sebagai teks (misal: "Demam, Batuk") agar history tetap ada
            // meskipun master data gejala dihapus nanti.
            $table->text('symptoms_snapshot')->nullable();

            // Catatan tambahan dokter/admin
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};

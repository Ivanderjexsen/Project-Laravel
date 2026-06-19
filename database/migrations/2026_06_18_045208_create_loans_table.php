<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('loans', function (Blueprint $table) {
        $table->id();
        $table->string('peminjam');          // nama peminjam
        $table->string('buku');              // judul buku
        $table->date('tanggal_pinjam');      // tanggal pinjam
        $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

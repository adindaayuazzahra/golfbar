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
        Schema::create('tb_peserta', function (Blueprint $table) {
            $table->id();
            $table->string('npp');
            $table->string('instansi');
            $table->string('nama');
            $table->bigInteger('whatsapp');
            $table->string('ukuran_baju');
            $table->string('handicap')->nullable();
            $table->integer('status'); // 0 tidak datang - 1 datang - 2 registrasi - 3 regis dan dapet hadiah 
            $table->unsignedBigInteger('id_grup')->nullable();
            $table->foreign('id_grup')->references('id')->on('tb_grup')->cascadeOnUpdate()->onDelete('set null');
            $table->unsignedBigInteger('id_hadiah')->nullable();
            $table->foreign('id_hadiah')->references('id')->on('tb_hadiah')->cascadeOnUpdate()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_peserta');
    }
};

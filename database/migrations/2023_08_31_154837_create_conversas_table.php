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
        Schema::create('conversas', function (Blueprint $table) {
            $table->id('conversa_id');
            $table->unsignedBigInteger('usuario1_id');
            $table->foreign('usuario1_id')->references('usuario_id')->on('usuarios');
            $table->unsignedBigInteger('usuario2_id');
            $table->foreign('usuario2_id')->references('usuario_id')->on('usuarios');
            $table->datetime('ultima_mensagem_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversas');
    }
};

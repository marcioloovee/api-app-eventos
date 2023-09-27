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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->unique();
            $table->text('bio');
            $table->string('foto_perfil_uri');
            $table->enum('sexo', ['M', 'F']);
            $table->date('data_nascimento');
            $table->bigInteger('seguindo')->default(0);
            $table->bigInteger('seguidores')->default(0);
            $table->string('username')->unique();
            $table->string('password');
            $table->date('email_confirmado_at');
            $table->date('ultima_atividade_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

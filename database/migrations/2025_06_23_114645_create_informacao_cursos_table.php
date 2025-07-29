<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('informacao_cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('informacao');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('informacao_cursos');
    }
};

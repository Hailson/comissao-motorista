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
        Schema::create('passagems', function (Blueprint $table) {
            $table->id();
            $table->string('frota');
            $table->bigInteger('quantidade_passagem');
            $table->string('tipo_passagem');
            $table->string('sentido_linha');
            $table->bigInteger('quant_excesso')->nullable()->default(0);
            $table->bigInteger('valor_excesso')->nullable()->default(0);
            $table->unsignedBigInteger('venda_id');
            $table->foreign('venda_id')->references('id')->on('vendas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passagems');
    }
};

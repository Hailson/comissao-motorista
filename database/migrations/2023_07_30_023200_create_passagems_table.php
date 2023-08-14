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
            $table->bigInteger('quantidade_passagem')->nullable();
            $table->bigInteger('quantidade_manual_ida')->nullable();
            $table->bigInteger('valor_manual_ida')->nullable();
            $table->bigInteger('quantidade_pos_ida')->nullable();
            $table->bigInteger('valor_pos_ida')->nullable();
            $table->bigInteger('quantidade_manual_volta')->nullable();
            $table->bigInteger('valor_manual_volta')->nullable();
            $table->bigInteger('quantidade_pos_volta')->nullable();
            $table->bigInteger('valor_pos_volta')->nullable();
            $table->bigInteger('quantidade_total_passagem')->nullable();
            $table->bigInteger('valor_total_manual')->nullable();
            $table->bigInteger('valor_total_pos')->nullable();
            $table->bigInteger('valor_total_passagem')->nullable();
            $table->bigInteger('valor_comissao')->nullable();
            $table->boolean('pagar_comissao')->default(true);
            $table->string('cobrador')->nullable();
            $table->string('tipo_passagem')->nullable();
            $table->string('sentido_linha')->nullable();
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

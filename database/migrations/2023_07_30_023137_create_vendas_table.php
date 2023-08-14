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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->date('data_venda');
            $table->unsignedBigInteger('linha_id');
            $table->unsignedBigInteger('colaborador_id');
            $table->foreign('linha_id')->references('id')->on('linhas');
            $table->foreign('colaborador_id')->references('id')->on('colaboradors');
            $table->bigInteger('valor_total');
            $table->boolean('paga_comissao')->default(false);
            $table->string('cobrador')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};

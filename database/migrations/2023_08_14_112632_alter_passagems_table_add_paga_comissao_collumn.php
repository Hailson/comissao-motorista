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
        Schema::table('passagems', function (Blueprint $table) {
            $table->boolean('pagar_comissao')->default(true);
            
            //$table->unsignedBigInteger('frota_id');
            //$table->foreign('frota_id')->references('id')->on('frotas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

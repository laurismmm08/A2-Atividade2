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
        Schema::create('holdings', function (Blueprint $table) {
            $table->id(); //conecta com user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('stock_symbol'); //codigo da ação
            $table->decimal('quantity', 10, 2); //A quantidade de ações que o usuario tem
            $table->decimal('purchase_price', 10, 2); //Preço para calcular ganho o perda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holdings');
    }
};

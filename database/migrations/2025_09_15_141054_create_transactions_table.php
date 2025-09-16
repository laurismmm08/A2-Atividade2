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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); //user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('stock_symbol'); //codigo da ação
            $table->enum('type', ['buy', 'sell']); //ou vende ou compra
            $table->decimal('quantity', 10, 2); //quantidade
            $table->decimal('price', 10, 2); //preço no momento da transação
            $table->timestamps(); //registro data e hora
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

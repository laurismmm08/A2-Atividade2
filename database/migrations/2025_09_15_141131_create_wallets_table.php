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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id(); //conceta usuario com carteira
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); //deleta usuario e carteira
            $table->decimal('cash_balance', 10, 2)->default(5000.00); //Saldo inicial
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};

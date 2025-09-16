<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Wallet;

class AssignInitialWallet
{
    //listener
    public function __construct()
    {
        //
    }

   
    public function handle(Registered $event): void
    {
        // Cria a carteira para que o novo usuariotenha um saldo inicial de 5000
        $wallet = new Wallet();
        $wallet->user_id = $event->user->id;
        $wallet->cash_balance = 5000.00;
        $wallet->save();
    }
}
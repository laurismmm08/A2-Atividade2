<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Holding extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'stock_symbol',
        'quantity',
        'purchase_price', // Adicione esta linha
    ];

    /**
     * Get the user that owns the holding.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
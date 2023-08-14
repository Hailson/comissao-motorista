<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passagem extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'pagar_comissao' => 'boolean',
    ];

    public function venda(): BelongsTo
    {
        return $this->belongsTo(Venda::class);
    }
}

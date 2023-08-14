<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_venda', 'linha_id', 'colaborador_id', 'valor_total', 'paga_comissao', 'cobrador', 'comissao'
    ];

    public function colaborador(): BelongsTo
    {
        return $this->belongsTo(Colaborador::class);
    }

    public function linha(): BelongsTo
    {
        return $this->belongsTo(Linha::class);
    }

    public function passagens(): HasMany
    {
        return $this->hasMany(Passagem::class);
    }
}

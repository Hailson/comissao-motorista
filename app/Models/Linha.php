<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Linha extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_linha', 'slug'
    ];

    public function vendas(): HasMany
    {
        return $this->hasMany(Venda::class);
    }
}

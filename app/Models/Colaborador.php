<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colaborador extends Model
{
    use HasFactory;

    protected $fillable =[
        'matricula', 'nome', 'apelido', 'admitido'
    ];

    public function vendas(): HasMany
    {
        return $this->hasMany(Venda::class);
    }
}

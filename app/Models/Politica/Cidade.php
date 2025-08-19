<?php

namespace App\Models\Politica;

use App\Models\Universal\Igreja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'politica_cidades';

    protected $fillable = [
        'nome',
        'ibge_code',
        'populacao',
        'votos_validos_ultima_eleicao',
        'cadeiras_camara',
    ];

    public function bairros()
    {
        return $this->hasMany(Bairro::class, 'cidade_id');
    }

    public function espelho()
    {
        return $this->hasOne(Espelho::class, 'cidade_id');
    }

    public function projecoes()
    {
        return $this->hasMany(Projecao::class, 'cidade_id');
    }

    public function igrejas()
    {
        return $this->hasMany(Igreja::class, 'cidade_id');
    }
}
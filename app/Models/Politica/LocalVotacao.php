<?php

namespace App\Models\Politica;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalVotacao extends Model
{
    use HasFactory;

    protected $table = 'politica_locais_votacao';

    protected $fillable = ['bairro_id', 'nome', 'endereco'];

    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'bairro_id');
    }

    public function votacoes()
    {
        return $this->hasMany(VotacaoDetalhada::class, 'local_votacao_id');
    }
}
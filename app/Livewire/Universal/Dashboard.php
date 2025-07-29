<?php

namespace App\Livewire\Universal;

use App\Models\Universal\Pastor;
use App\Models\Universal\Igreja;
use App\Models\Universal\Pessoa;
use App\Models\Universal\Regiao;
use App\Models\Universal\Bloco;
use App\Models\Universal\Banner;
use App\Models\Universal\Categoria;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    // Contadores para os cards
    public $pessoasCount;
    public $igrejasCount;
    public $pastoresCount;
    public $regioesCount;
    public $blocosCount;
    public $bannersCount;
    public $categoriasCount;

    // Dados para listas e gráficos
    public $igrejasPorRegiao;
    public $chartPessoasPorRegiao;
    
    // AJUSTE: Renomeada a propriedade do gráfico
    public $chartIgrejasPorBloco;

    // Mensagem de feedback
    public $message = '';

    public function mount()
    {
        $this->refreshDashboard();
    }

    public function refreshDashboard()
    {
        // Contagem para os cards
        $this->pessoasCount = Pessoa::count();
        $this->igrejasCount = Igreja::count();
        $this->pastoresCount = Pastor::count();
        $this->regioesCount = Regiao::count();
        $this->blocosCount = Bloco::count();
        $this->bannersCount = Banner::count();
        $this->categoriasCount = Categoria::count();

        // Lista de Igrejas por Região
        $this->igrejasPorRegiao = Igreja::select('regiao_id', DB::raw('COUNT(*) as total_igrejas'))
            ->groupBy('regiao_id')
            ->with('regiao:id,nome')
            ->get()
            ->map(fn($item) => [
                'regiao' => $item->regiao->nome ?? 'Sem Região',
                'total_igrejas' => $item->total_igrejas,
            ])
            ->sortBy('regiao')
            ->toArray();

        // Dados para Gráfico 1: Pessoas por Região
        $pessoasData = Pessoa::select('regiao_id', DB::raw('COUNT(*) as total_pessoas'))
            ->groupBy('regiao_id')
            ->with('regiao:id,nome')
            ->get();

        $this->chartPessoasPorRegiao = [
            'labels' => $pessoasData->pluck('regiao.nome')->map(fn($name) => $name ?? 'Sem Região')->toArray(),
            'data' => $pessoasData->pluck('total_pessoas')->toArray(),
        ];

        // AJUSTE: Lógica do gráfico de banners foi substituída pela de igrejas por bloco.
        $igrejasPorBlocoData = Igreja::select('bloco_id', DB::raw('COUNT(*) as total_igrejas'))
            ->groupBy('bloco_id')
            ->with('bloco:id,nome')
            ->orderBy('total_igrejas', 'desc')
            ->get();

        $this->chartIgrejasPorBloco = [
            'labels' => $igrejasPorBlocoData->pluck('bloco.nome')->map(fn($name) => $name ?? 'Sem Bloco')->toArray(),
            'data' => $igrejasPorBlocoData->pluck('total_igrejas')->toArray(),
        ];
        
        $this->dispatch('dashboardRefreshed');
        $this->message = 'Dashboard atualizado com sucesso!';
    }

    public function redirectTo($route)
    {
        return redirect()->route($route);
    }

    public function exportData()
    {
        $this->message = 'Exportação iniciada...';
    }

    public function render()
    {
        return view('livewire.universal.dashboard');
    }
}
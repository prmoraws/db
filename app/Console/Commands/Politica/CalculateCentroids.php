<?php

namespace App\Console\Commands\Politica;

use Illuminate\Console\Command;
use App\Models\Politica\Cidade;
use Illuminate\Support\Facades\DB;

class CalculateCentroids extends Command
{
    protected $signature = 'politica:calculate-centroids {filepath : O caminho para o arquivo CSV de coordenadas do IBGE}';
    protected $description = 'Calcula o centroide (média de coordenadas) para cada município a partir do arquivo do Censo e atualiza o banco de dados.';

    public function handle()
    {
        $filepath = base_path($this->argument('filepath'));
        if (!file_exists($filepath)) {
            $this->error("Arquivo não encontrado em: {$filepath}");
            return 1;
        }

        // --- FASE 1: LER O ARQUIVO GRANDE E AGREGAR OS DADOS EM MEMÓRIA ---
        $this->info('FASE 1: Lendo e agregando os dados de coordenadas (pode demorar)...');
        $municipalities = [];
        $fileHandle = fopen($filepath, 'r');
        fgetcsv($fileHandle, 0, ';'); // Pula cabeçalho

        $totalLines = count(file($filepath)) - 1;
        $progressBar = $this->output->createProgressBar($totalLines);
        
        while (($row = fgetcsv($fileHandle, 0, ';')) !== false) {
            $progressBar->advance();
            $cod_mun = $row[1] ?? null; // COD_MUN
            $lat = (float)($row[3] ?? 0); // LATITUDE
            $lon = (float)($row[4] ?? 0); // LONGITUDE

            if (!$cod_mun || $lat == 0 || $lon == 0) continue;

            if (!isset($municipalities[$cod_mun])) {
                $municipalities[$cod_mun] = ['total_lat' => 0.0, 'total_lon' => 0.0, 'count' => 0];
            }

            $municipalities[$cod_mun]['total_lat'] += $lat;
            $municipalities[$cod_mun]['total_lon'] += $lon;
            $municipalities[$cod_mun]['count']++;
        }
        fclose($fileHandle);
        $progressBar->finish();
        $this->info("\nAgregação concluída. " . count($municipalities) . " municípios encontrados no arquivo.");

        // --- FASE 2: CALCULAR A MÉDIA E ATUALIZAR O BANCO DE DADOS ---
        $this->info('FASE 2: Calculando as médias e atualizando o banco de dados...');
        $updateProgressBar = $this->output->createProgressBar(count($municipalities));
        
        DB::beginTransaction();
        foreach ($municipalities as $ibge_code => $data) {
            $avg_lat = $data['total_lat'] / $data['count'];
            $avg_lon = $data['total_lon'] / $data['count'];

            Cidade::where('ibge_code', $ibge_code)->update([
                'latitude' => $avg_lat,
                'longitude' => $avg_lon,
            ]);
            $updateProgressBar->advance();
        }
        DB::commit();
        $updateProgressBar->finish();

        $this->info("\n\nCoordenadas atualizadas com sucesso com base no Censo 2022!");
        return 0;
    }
}
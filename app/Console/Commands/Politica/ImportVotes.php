<?php

namespace App\Console\Commands\Politica;

use Illuminate\Console\Command;
use App\Models\Politica\{Cidade, Bairro, LocalVotacao, Candidato, VotacaoDetalhada};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportVotes extends Command
{
    /**
     * A assinatura do comando, que define seu nome e argumentos.
     */
    protected $signature = 'politica:import-votes 
                            {filepath : O caminho para o arquivo CSV a partir da raiz do projeto}
                            {--cargo= : O cargo a ser importado (ex: "DEPUTADO ESTADUAL")}
                            {--candidato=* : Nomes exatos dos candidatos para filtrar a importação}';

    /**
     * A descrição do comando.
     */
    protected $description = 'Importa os votos detalhados de um arquivo CSV oficial do TSE de forma otimizada e filtrada.';

    /**
     * Executa a lógica do comando.
     */
    public function handle()
    {
        $filepath = $this->argument('filepath');
        $cargoFilter = mb_strtoupper($this->option('cargo'), 'UTF-8');
        $candidatosFilter = $this->option('candidato');

        if (empty($cargoFilter)) {
            $this->error('O filtro --cargo é obrigatório. Ex: --cargo="DEPUTADO ESTADUAL"');
            return 1;
        }

        $csvPath = base_path($filepath);
        if (!file_exists($csvPath)) {
            $this->error("Arquivo não encontrado em: {$csvPath}");
            return 1;
        }

        $cidadesCache = Cidade::pluck('id', 'ibge_code')->toArray();
        $bairrosCache = [];
        $locaisVotacaoCache = [];
        $candidatosCache = Candidato::pluck('id', 'nome')->toArray();
        $votacaoData = [];
        $chunkSize = 1000;

        $this->info("Iniciando importação para o cargo: {$cargoFilter}");
        if (!empty($candidatosFilter)) {
            $this->info('Filtrando pelos candidatos: ' . implode(', ', $candidatosFilter));
        }

        $fileHandle = fopen($csvPath, 'r');
        fgetcsv($fileHandle, 0, ';'); // Pula cabeçalho

        $totalLines = count(file($csvPath)) - 1;
        $progressBar = $this->output->createProgressBar($totalLines);
        
        DB::beginTransaction();
        
        while (($row = fgetcsv($fileHandle, 0, ';')) !== false) {
            $progressBar->advance();
            $row = array_map(fn($item) => mb_convert_encoding($item, 'UTF-8', 'ISO-8859-1'), $row);

            // --- CORREÇÃO: Filtra apenas linhas da Bahia (BA) ---
            $siglaUF = $row[10] ?? ''; // SG_UF (Posição 11)
            if ($siglaUF !== 'BA') {
                continue; // Pula a linha se não for da Bahia
            }
            // --- FIM DA CORREÇÃO ---

            $cargo = mb_strtoupper($row[18] ?? '', 'UTF-8');
            $nomeVotavel = $row[20] ?? null;
            
            if ($cargo !== $cargoFilter) continue;
            if (!empty($candidatosFilter) && !in_array($nomeVotavel, $candidatosFilter)) continue;
            
            $votos = (int)($row[21] ?? 0);
            if ($votos === 0 || empty($nomeVotavel) || $nomeVotavel === '#NULO' || $nomeVotavel === '#NE') continue;

            $ibgeCode = $row[13] ?? null;
            $nomeMunicipio = mb_strtoupper($row[14] ?? '', 'UTF-8');
            if(empty($ibgeCode) || empty($nomeMunicipio)) continue;

            if (!isset($cidadesCache[$ibgeCode])) {
                $cidade = Cidade::create(['ibge_code' => $ibgeCode, 'nome' => $nomeMunicipio]);
                $cidadesCache[$ibgeCode] = $cidade->id;
            }
            $cidadeId = $cidadesCache[$ibgeCode];
            
            // ... (o restante da lógica de importação permanece o mesmo)
            $bairroKey = $cidadeId . '_BAIRRO NÃO INFORMADO';
            if (!isset($bairrosCache[$bairroKey])) {
                $bairro = Bairro::create(['cidade_id' => $cidadeId, 'nome' => 'BAIRRO NÃO INFORMADO']);
                $bairrosCache[$bairroKey] = $bairro->id;
            }
            $bairroId = $bairrosCache[$bairroKey];

            $nomeLocalVotacao = $row[24] ?? 'LOCAL NÃO INFORMADO';
            $localKey = $cidadeId . '_' . $nomeLocalVotacao;
            if (!isset($locaisVotacaoCache[$localKey])) {
                $zona = $row[15] ?? ''; $secao = $row[16] ?? '';
                $local = LocalVotacao::create([
                    'bairro_id' => $bairroId,
                    'cidade_id' => $cidadeId,
                    'nome' => $nomeLocalVotacao,
                    'endereco' => "Zona: {$zona} / Seção: {$secao}"
                ]);
                $locaisVotacaoCache[$localKey] = $local->id;
            }
            $localVotacaoId = $locaisVotacaoCache[$localKey];

            if (!isset($candidatosCache[$nomeVotavel])) {
                $candidato = Candidato::create(['nome' => $nomeVotavel]);
                $candidatosCache[$nomeVotavel] = $candidato->id;
            }
            $candidatoId = $candidatosCache[$nomeVotavel];

            $votacaoData[] = [
                'local_votacao_id' => $localVotacaoId,
                'candidato_id' => $candidatoId,
                'ano_eleicao' => 2022,
                'cargo' => $cargo,
                'votos_recebidos' => $votos,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($votacaoData) >= $chunkSize) {
                DB::table('politica_votacao_detalhada')->insert($votacaoData);
                $votacaoData = [];
            }
        }

        if (!empty($votacaoData)) {
            DB::table('politica_votacao_detalhada')->insert($votacaoData);
        }

        DB::commit();
        fclose($fileHandle);
        $progressBar->finish();
        $this->info("\n\nImportação otimizada concluída com sucesso!");
        return 0;
    }
}
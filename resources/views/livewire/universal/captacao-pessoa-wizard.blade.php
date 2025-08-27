@section('title', 'Cadastro UNP')

<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center p-4">
    <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
        
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-200 mb-4">Cadastro UNP</h2>
            <div class="relative pt-1">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200 dark:bg-blue-900">
                    <div style="width:{{ ($step - 1) / ($totalSteps - 1) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-500"></div>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            @if(session()->has('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- Etapa 1: Boas-vindas --}}
            @if($step === 1)
            <div class="text-center">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Seja Bem-vindo(a)!</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Estamos felizes com seu interesse em fazer parte. Este formulário levará apenas alguns minutos.</p>
                <button wire:click="nextStep" type="button" class="mt-6 w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Iniciar Cadastro</button>
            </div>
            @endif

            {{-- Etapa 2: Igreja e Função --}}
            @if($step === 2)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">1. Sua Igreja e Função</h3>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 border rounded-md dark:border-gray-700">
                        <div>
                            <label for="bloco_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bloco</label>
                            <select wire:model.live="bloco_id" id="bloco_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                                <option value="">Selecione</option>
                                @foreach($allBlocos as $bloco) <option value="{{ $bloco->id }}">{{ $bloco->nome }}</option> @endforeach
                            </select>
                            @error('bloco_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="regiao_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Região</label>
                            <select wire:model.live="regiao_id" id="regiao_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700" @if(empty($regiaos)) disabled @endif>
                                <option value="">Selecione</option>
                                @foreach($regiaos as $regiao) <option value="{{ $regiao->id }}">{{ $regiao->nome }}</option> @endforeach
                            </select>
                            @error('regiao_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="igreja_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Igreja</label>
                            <select wire:model.lazy="igreja_id" id="igreja_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700" @if(empty($igrejas)) disabled @endif>
                                <option value="">Selecione</option>
                                @foreach($igrejas as $igreja) <option value="{{ $igreja->id }}">{{ $igreja->nome }}</option> @endforeach
                            </select>
                            @error('igreja_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-4 border rounded-md dark:border-gray-700">
                        <div>
                            <label for="categoria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoria</label>
                            <select wire:model.lazy="categoria_id" id="categoria_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                                <option value="">Selecione</option>
                                @foreach($allCategorias as $categoria) <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option> @endforeach
                            </select>
                            @error('categoria_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="cargo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cargo</label>
                            <select wire:model.lazy="cargo_id" id="cargo_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                                <option value="">Selecione</option>
                                @foreach($allCargos as $cargo) <option value="{{ $cargo->id }}">{{ $cargo->nome }}</option> @endforeach
                            </select>
                            @error('cargo_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="grupo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                @if($selectedBlocoName === 'Catedral') Grupo Catedral @else Grupo @endif
                            </label>
                            <select wire:model.lazy="grupo_id" id="grupo_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed" @if($selectedBlocoName !== 'Catedral') disabled @endif>
                                <option value="">Selecione</option>
                                @foreach($allGrupos as $grupo) <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option> @endforeach
                            </select>
                            @error('grupo_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Etapa 3: Dados Pessoais --}}
            @if($step === 3)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">2. Dados Pessoais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome Completo</label>
                        <input type="text" wire:model.lazy="nome" id="nome" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                        @error('nome') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="celular" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Celular (com DDD)</label>
                        <input type="text" wire:model.lazy="celular" id="celular" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                        @error('celular') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" wire:model.lazy="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto</label>
                        <input type="file" wire:model="foto" id="foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/50 dark:file:text-blue-300 dark:hover:file:bg-blue-800/50">
                        @if ($foto) <img src="{{ $foto->temporaryUrl() }}" class="mt-2 h-20 w-20 object-cover rounded-full"> @endif
                        @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Etapa 4: Endereço --}}
            @if($step === 4)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">3. Endereço</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="estado_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                        <select wire:model.live="estado_id" id="estado_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                            <option value="">Selecione</option>
                            @foreach($allEstados as $estado) <option value="{{ $estado->id }}">{{ $estado->nome }}</option> @endforeach
                        </select>
                        @error('estado_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="cidade_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cidade</label>
                        <select wire:model.lazy="cidade_id" id="cidade_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700" @if(empty($cidades)) disabled @endif>
                            <option value="">Selecione</option>
                            @foreach($cidades as $cidade) <option value="{{ $cidade->id }}">{{ $cidade->nome }}</option> @endforeach
                        </select>
                        @error('cidade_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="endereco" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Endereço (Rua, Nº)</label>
                        <input type="text" wire:model.lazy="endereco" id="endereco" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                        @error('endereco') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="bairro" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bairro</label>
                        <input type="text" wire:model.lazy="bairro" id="bairro" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                        @error('bairro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif

            {{-- Etapa 5: Informações Adicionais --}}
            @if($step === 5)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">4. Informações Adicionais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                    <div class="md:col-span-2">
                        <label for="profissao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profissão</label>
                        <input type="text" wire:model.lazy="profissao" id="profissao" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                    </div>
                    <div>
                        <label for="conversao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de Conversão</label>
                        <input type="date" wire:model.lazy="conversao" id="conversao" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                    </div>
                    <div>
                        <label for="obra" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Entrada na Obra</label>
                        <input type="date" wire:model.lazy="obra" id="obra" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700">
                    </div>
                    <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4">
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Trabalho</p>
                            <label class="flex items-center"><input type="checkbox" wire:model.lazy="trabalho" value="interno" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><span class="ml-2">Interno</span></label>
                            <label class="flex items-center"><input type="checkbox" wire:model.lazy="trabalho" value="externo" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><span class="ml-2">Externo</span></label>
                        </div>
                        <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Batismo</p>
                            <label class="flex items-center"><input type="checkbox" wire:model.lazy="batismo" value="aguas" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><span class="ml-2">Nas Águas</span></label>
                            <label class="flex items-center"><input type="checkbox" wire:model.lazy="batismo" value="espirito" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><span class="ml-2">Com Espírito Santo</span></label>
                        </div>
                         <div class="space-y-2">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Situação</p>
                            <label class="flex items-center"><input type="checkbox" wire:model.lazy="preso" value="preso" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><span class="ml-2">Já foi Preso(a)</span></label>
                            <label class="flex items-center"><input type="checkbox" wire:model.lazy="preso" value="familiar" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"><span class="ml-2">Familiar Preso</span></label>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Etapa 6: Testemunho --}}
            @if($step === 6)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">5. Seu Testemunho</h3>
                <div>
                    <label for="testemunho" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descreva seu testemunho aqui</label>
                    <textarea wire:model.lazy="testemunho" id="testemunho" rows="8" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700"></textarea>
                    @error('testemunho') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            @endif

            {{-- Etapa 7: Revisão --}}
            @if($step === 7)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">6. Revise suas Informações</h3>
                <div class="space-y-6">
                    <div>
                        <h4 class="font-semibold text-blue-600 dark:text-blue-400 border-b dark:border-gray-600 pb-2 mb-3">Dados Pessoais</h4>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="sm:col-span-2 flex items-center gap-4">
                                @if($foto) <img src="{{ $foto->temporaryUrl() }}" class="h-16 w-16 object-cover rounded-full"> @endif
                                <div><dt class="text-sm font-medium text-gray-500">Nome</dt> <dd class="text-base text-gray-900 dark:text-gray-100">{{ $nome }}</dd></div>
                            </div>
                            <div><dt class="text-sm font-medium text-gray-500">Celular</dt> <dd>{{ $celular }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Email</dt> <dd>{{ $email ?: 'Não informado' }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Profissão</dt> <dd>{{ $profissao ?: 'Não informado' }}</dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Endereço</dt> <dd>{{ $endereco }}, {{ $bairro }} - {{ optional(collect($cidades)->firstWhere('id', $cidade_id))->nome }} / {{ optional($allEstados->firstWhere('id', $estado_id))->uf }}</dd></div>
                        </dl>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-600 dark:text-blue-400 border-b dark:border-gray-600 pb-2 mb-3">Filiação Eclesiástica</h4>
                        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4">
                            <div><dt class="text-sm font-medium text-gray-500">Bloco</dt> <dd>{{ optional($allBlocos->firstWhere('id', $bloco_id))->nome }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Região</dt> <dd>{{ optional(collect($regiaos)->firstWhere('id', $regiao_id))->nome }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Igreja</dt> <dd>{{ optional(collect($igrejas)->firstWhere('id', '==', $igreja_id))->nome }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Categoria</dt> <dd>{{ optional($allCategorias->firstWhere('id', $categoria_id))->nome }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Cargo</dt> <dd>{{ optional($allCargos->firstWhere('id', $cargo_id))->nome }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Grupo</dt> <dd>{{ optional($allGrupos->firstWhere('id', $grupo_id))->nome ?: 'N/A' }}</dd></div>
                        </dl>
                    </div>
                    <div>
                         <h4 class="font-semibold text-blue-600 dark:text-blue-400 border-b dark:border-gray-600 pb-2 mb-3">Jornada Espiritual</h4>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            <div><dt class="text-sm font-medium text-gray-500">Conversão</dt> <dd>{{ $conversao ? \Carbon\Carbon::parse($conversao)->format('d/m/Y') : 'Não informado' }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Entrada na Obra</dt> <dd>{{ $obra ? \Carbon\Carbon::parse($obra)->format('d/m/Y') : 'Não informado' }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Trabalho</dt> <dd class="capitalize">{{ !empty($trabalho) ? implode(', ', $trabalho) : 'Não informado' }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500">Batismo</dt> <dd class="capitalize">{{ !empty($batismo) ? implode(', ', $batismo) : 'Não informado' }}</dd></div>
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Situação</dt> <dd class="capitalize">{{ !empty($preso) ? implode(', ', $preso) : 'Não informado' }}</dd></div>
                             @if($testemunho)
                            <div class="sm:col-span-2"><dt class="text-sm font-medium text-gray-500">Testemunho</dt> <dd class="italic text-gray-600 dark:text-gray-400">"{{ \Illuminate\Support\Str::limit($testemunho, 200) }}"</dd></div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
            @endif
            
            {{-- Etapa 8: Sucesso --}}
            @if($step === 8)
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-gray-100">Cadastro Enviado!</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Obrigado! Suas informações foram enviadas para análise. Entraremos em contato em breve.</p>
            </div>
            @endif
        </div>

        {{-- Botões de Navegação --}}
        <div class="p-6 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
            @if ($step > 1 && $step < $totalSteps)
                <div class="flex justify-between items-center">
                    <button wire:click="previousStep" type="button" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">Voltar</button>
                    <div wire:loading wire:target="nextStep, submit" class="text-sm text-gray-500">Processando...</div>
                    @if($step == $totalSteps - 1)
                        <button wire:click="submit" wire:loading.attr="disabled" type="button" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 disabled:opacity-50">Enviar Cadastro</button>
                    @else
                        <button wire:click="nextStep" wire:loading.attr="disabled" type="button" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 disabled:opacity-50">Próximo</button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
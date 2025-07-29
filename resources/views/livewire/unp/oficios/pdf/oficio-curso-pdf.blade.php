<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Ofício de Curso</title>
    <style>
        /* Cores base Tailwind para referência */
        /* blue-950: #172554 */
        /* red-600: #dc2626 */
        /* gray-900: #111827 */
        /* blue-700: #1d4ed8 */


        @page {
            margin: 5mm 10mm;
            /* Top/Bottom 5mm, Left/Right 10mm */
            size: A4 portrait;
        }

        body {
            background-color: #fff;
            color: #000;
            /* text-black */
            font-family: sans-serif;
            /* font-sans */
            font-size: 14px;
            /* text-sm */
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: calc(297mm - 10mm);
            /* A4 height - (top_margin + bottom_margin) */
            overflow: hidden;
            /* Crucial para evitar quebra de página */
        }

        header {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            border-bottom: 3px solid #172554;
            padding-bottom: 1mm;
            margin-bottom: 1mm;
            opacity: 0.75;
            height: 25px;
            /* Altura fixa para o cabeçalho */
        }

        header img {
            width: 150px;
            height: auto;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            margin: 0px 0;
            color: #616161;
            padding-left: 10px;
        }

        main {
            padding-top: 10px;
            /* pt-6 */
            flex-grow: 1;
            /* flex-grow */
            display: flex;
            /* flex */
            flex-direction: column;
            /* flex-col */
            overflow: hidden;
            /* Crucial para evitar quebra de página */
        }

        .dados {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 10px;
        }

        .texto-dados {
            text-align: left;
            font-size: 12px;
            line-height: 1.4;
            flex: 1;
        }

        .texto-dados p {
            margin: 5px 0;
            padding-left: 15px;
        }

        .caixa-confirmacao {
            width: 200px;
            border: 1px solid #dc2626;
            padding: 8px;
            font-size: 10px;
            color: #dc2626;
            font-weight: bold;
            flex-shrink: 0;
        }

        .caixa-confirmacao p {
            margin: 8px 0;
            line-height: 1.3;
        }

        @media print {
            .caixa-confirmacao {
                position: absolute;
                right: 0;
                top: 90px;
                /* Ajuste conforme a altura do seu header e título */
                margin-left: 0;
                /* Override ml-8 */
            }
        }

        .corpo {
            margin-top: 24px;
            /* mt-6 */
            font-size: 12px;
            /* text-sm */
            text-align: justify;
            line-height: 1.4;
            /* leading-snug (1.375) - ajustado */
            padding: 0 20px;
            /* px-5 */
            flex-grow: 1;
            overflow: hidden;
        }

        .corpo>p {
            text-indent: 32px;
            /* indent-8 */
            margin-bottom: 16px;
            /* mb-4 */
            /* padding-bottom: 40px; pb-10 */
            /* Ajustar no HTML se necessário */
        }


        .instrutor,
        .material {
            margin-left: 64px;
            /* ml-16 */
            margin-top: 16px;
            /* mt-4 */
            margin-bottom: 16px;
            /* mb-4 */
            line-height: 1.5;
            /* Ajustado */
        }

        .instrutor p,
        .material>p {
            text-indent: 0;
            padding: 0;
            margin: 0;
            /* Removido margin-bottom para espaçamento mais apertado */

            font-weight: bold;
            /* font-bold */
            padding-bottom: 16px;
            /* pb-4 */
        }

        .instrutor ul {
            list-style-type: disc;
            margin-left: 80px;
            /* ml-20 */
            font-weight: 600;
            /* font-semibold */
            font-size: 14px;
            /* text-sm */
            line-height: 1.4;
            /* Ajustado */
            padding: 0;
            /* Remover padding padrão de UL */
        }

        .instrutor ul li {
            margin-bottom: 4px;
            /* Pequeno espaço entre os itens da lista */
        }


        .material .conteudo-material {
            margin-left: 64px;
            /* ml-16 */
            font-style: italic;
            font-weight: 600;
            /* font-semibold */
            text-indent: 0;
            padding: 0 30px 0 20px;
            margin: 0;
            margin-top: 4px;
            /* mt-1 */
            white-space: pre-line;
        }

        .assinatura {
            margin-top: 20px;
            /* Reduzido */
            padding-bottom: 5px;
            text-align: center;
            flex: none;
            /* Remove flex-grow */
        }

        .assinatura-img-container {
            display: inline-block;
            margin-top: 5px;
            /* Reduzido */
        }

        .assinatura img {
            height: 60px;
            /* Reduzido */
            display: block;
            margin: 0 auto;
        }

        .assinatura .linha {
            border-top: 1px solid #000;
            margin-top: 3px;
            width: 100%;
        }

        .assinatura .assinatura-texto p {
            margin: 2px 0;
            font-size: 11px;
        }

        footer {
            text-align: center;
            opacity: 0.75;
            border-top: 4px solid #172554;
            padding: 5px 0;
            font-size: 10px;
            flex-shrink: 0;
            /* Impede que o footer cresça */
        }

        .footer-banner {
            border-top: 1px solid #172554;
            border-bottom: 1px solid #172554;
            margin: 5px auto;
            display: inline-block;
            padding: 2px 15px;
            font-size: 14px;
            font-weight: bold;
            color: #172554;
        }

        .footer-banner span {
            color: #dc2626;
        }

        /* --- Estilos para Botões e Mídia de Impressão --- */
        .controls-container {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f0f0f0;
            border-bottom: 1px solid #ccc;
        }

        .controls-container button {
            background-color: #2563eb;
            /* blue-600 */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .controls-container button:hover {
            background-color: #1d4ed8;
            /* blue-700 */
        }

        /* Esconder os controles na impressão */
        @media print {
            .controls-container {
                display: none;
            }

            @page {
                margin: 0 !important;
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                height: 100% !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    {{-- Controles de Impressão (Visíveis apenas na tela, escondidos na impressão) --}}
    <div class="controls-container">
        <button onclick="window.print()">Imprimir Ofício</button>
    </div>

    <header>
        <img src="{{ asset('formaturas/logo-unp.png') }}" alt="Logo UNP">
    </header>

    <p class="title">Coordenadoria de Evangelização Estadual nas Unidades Prisionais</p>

    <main>
        <div class="dados">
            <div class="texto-dados">
                <p><strong>{{ $selectedOficio->numero_oficio }}</strong></p>
                <p style="padding-bottom: 0.5em;">{{ $selectedOficio->data_formatada }}</p>
                <p><strong>{{ $selectedOficio->destinatario }}</strong></p>
                <p><strong>ASSUNTO: SOLICITAÇÃO DE INÍCIO DE CURSO</strong></p>
                <p><strong>{{ $selectedOficio->diretor_formatado }}</strong></p>
            </div>

            <div class="caixa-confirmacao">
                <p style="text-align: center;">Confirmo recebimento e dou ciência.</p>
                <p>Nome: ____________________________</p>
                <p>Assinatura: _______________________</p>
                <p>Data: _______/ _______/ _________</p>
            </div>
        </div>

        <div class="corpo">
            <p style="text-indent: 32px; margin-bottom: 16px; padding: 0 20px;">{!! $selectedOficio->paragrafo_principal !!}</p>

            <div class="instrutor">
                <p>Instrutor será:</p>
                <ul>
                    <li>{{ $selectedOficio->curso->instrutor->nome ?? 'N/A' }}</li>
                    <li>RG: {{ $selectedOficio->curso->instrutor->rg ?? 'N/A' }}</li>
                    <li>CPF: {{ $selectedOficio->curso->instrutor->cpf ?? 'N/A' }}</li>
                </ul>
            </div>

            @if ($selectedOficio->material)
                <div class="material">
                    <p>Material a ser usado:</p>
                    <p class="conteudo-material">{{ $selectedOficio->material }}</p>
                </div>
            @endif

            <p style="text-indent: 32px; margin-bottom: 16px; padding: 0 20px;">Cumpre salientar nossa Instituição
                continua
                comprometida a corroborar com os cuidados necessários em que lhe compete, contribuindo e atendendo as
                orientações e determinações da Unidade. De plano, registra e reitera protestos de elevada estima e
                consideração. Que o Senhor Deus os abençoe!</p>
        </div>

        <div class="assinatura">
            <p>Atenciosamente,</p>
            <div class="assinatura-img-container">
                <img src="{{ asset('formaturas/assinatura-pastor.png') }}" alt="Assinatura">
                <div class="linha"></div>
                <div class="assinatura-texto">
                    <p class="nome-pastor">Pastor Pedro Paulo Dos Santos</p>
                    <p>Coordenador da UNP no Estado da Bahia</p>
                    <p class="email-contato">Contato e WhatsApp (11)95857-9899 | <span>E-mail:
                            pedropasantos@universal.org</span></p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p class="footer-banner">UNIVERSAL NOS <span>PRESÍDIOS</span></p>
        <p>Avenida Antônio Carlos Magalhães, 4197 Pituba, Salvador - BA 40280-000</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.print(); // Aciona a impressão assim que a página é carregada
        });
    </script>
</body>

</html>

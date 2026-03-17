<?php
session_start();
require_once "../api/db.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Premium | Marcella Beauty</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primaria: #4B1FA1;
            --primaria-clara: #6b3fc9;
            --primaria-ultra-clara: #f5f0ff;
            --destaque: #d9b3ff;
            --cor-fundo: #f8fafc;
            --texto-principal: #1e293b;
            --texto-suave: #64748b;
            --branco: #ffffff;
            --sombra: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            --raio-borda: 12px;
            --perigo: #ef4444;
            --sucesso: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--cor-fundo);
            color: var(--texto-principal);
            line-height: 1.6;
        }

        /* ===== CABEÇALHO ===== */
        .cabecalho-principal {
            background-color: var(--branco);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .cabecalho-principal h1 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--primaria);
            text-transform: uppercase;
        }

        .acoes-cabecalho {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        /* ===== FILTROS GLOBAIS ===== */
        .filtros-globais {
            display: flex;
            gap: 10px;
            background: var(--primaria-ultra-clara);
            padding: 6px;
            border-radius: 10px;
            border: 1px solid var(--destaque);
        }

        .filtros-globais select {
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--primaria);
            cursor: pointer;
            outline: none;
            padding: 2px 5px;
        }

        /* ===== CONTEÚDO PRINCIPAL ===== */
        .conteudo-principal {
            width: 92%;
            max-width: 1400px;
            margin: 1.5rem auto;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .cartao {
            background-color: var(--branco);
            padding: 1.5rem;
            border-radius: var(--raio-borda);
            box-shadow: var(--sombra);
            border: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
        }

        .cartao h2 {
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--texto-principal);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--cor-fundo);
        }

        /* ===== MÉTRICAS ===== */
        .painel-metricas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .cartao-metricas {
            background: var(--branco);
            padding: 1.5rem;
            border-radius: var(--raio-borda);
            box-shadow: var(--sombra);
            border: 1px solid #f1f5f9;
        }

        .valor-metricas {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .descricao-metricas {
            font-size: 0.7rem;
            color: var(--texto-suave);
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .tendencia-metricas {
            font-size: 0.65rem;
            font-weight: 700;
        }

        /* ===== FILTROS DE GRÁFICO ===== */
        .filtros-grafico {
            display: flex;
            gap: 8px;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .botao-filtro {
            padding: 6px 12px;
            font-size: 0.65rem;
            font-weight: 700;
            border: 1px solid #e2e8f0;
            background: var(--branco);
            color: var(--texto-suave);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
            text-transform: uppercase;
        }

        .botao-filtro.ativo {
            background: var(--primaria);
            color: var(--branco);
            border-color: var(--primaria);
        }

        /* ===== GRÁFICOS ===== */
        .grid-graficos {
            display: grid;
            grid-template-columns: 1.4fr 1.6fr;
            gap: 1.5rem;
            margin-top: 1rem;
        }

        .container-grafico {
            position: relative;
            width: 100%;
            min-height: 450px;
        }

        /* ===== REGRAS DE AGENDA ===== */
        .grupo-entrada {
            margin-bottom: 1.2rem;
        }

        .grupo-entrada strong {
            display: block;
            font-size: 0.65rem;
            color: var(--texto-suave);
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .seletor-tipo {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }

        .botao-tipo {
            flex: 1;
            padding: 10px;
            font-size: 0.7rem;
            font-weight: 700;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .botao-tipo.ativo.trabalho {
            background: var(--sucesso);
            color: white;
            border-color: var(--sucesso);
        }

        .botao-tipo.ativo.folga {
            background: var(--perigo);
            color: white;
            border-color: var(--perigo);
        }

        .seletor-dia {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .botao-dia {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .botao-dia.ativo {
            background: var(--primaria);
            color: white;
            border-color: var(--primaria);
        }

        input[type="time"] {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            font-family: inherit;
        }

        @media (max-width: 1000px) {

            .layout-grid,
            .grid-graficos {
                grid-template-columns: 1fr;
            }

            .acoes-cabecalho {
                flex-direction: column-reverse;
                align-items: flex-end;
                gap: 0.5rem;
            }
        }

        /* --- APARÊNCIA ESTILO PRIMEIRO CÓDIGO --- */
        #calendarioMini {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #edf2f7;
        }

        .fc .fc-toolbar-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #4B1FA1;
            text-transform: capitalize;
            letter-spacing: 1px;
        }

        /* --- BOTÕES DO CALENDÁRIO (visíveis e estilizados) --- */
        .fc .fc-button {
            background-color: #f3f3f3 !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 4px 10px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: #4B1FA1 !important;
            /* cor principal */
            cursor: pointer;
            transition: background-color 0.2s;
            box-shadow: none !important;
        }

        .fc .fc-button:hover {
            background-color: #e0d4ff !important;
        }

        .fc .fc-button:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background-color: #4B1FA1 !important;
            color: white !important;
        }
    </style>
</head>

<body>

    <header class="cabecalho-principal">
        <h1>Marcella Beauty Admin</h1>
        <div class="acoes-cabecalho">
            <div class="filtros-globais">
                <select id="filtroMes" onchange="aplicarFiltrosGlobais()">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3" selected>Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
                <select id="filtroAno" onchange="aplicarFiltrosGlobais()">
                    <option value="2026" selected>2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                </select>
            </div>
        </div>
    </header>

    <div class="conteudo-principal">

        <div class="layout-grid">
            <div class="cartao">
                <h2>Gerenciar Disponibilidade</h2>

                <div class="grupo-entrada">
                    <strong>Tipo de Regra</strong>
                    <div class="seletor-tipo">
                        <div class="botao-tipo ativo trabalho" data-tipo="trabalho" onclick="alternarTipo(this)">
                            Trabalho</div>
                        <div class="botao-tipo folga" data-tipo="folga" onclick="alternarTipo(this)">Folga / Fechado
                        </div>
                    </div>
                </div>

                <div class="grupo-entrada">
                    <strong>Dias da Semana</strong>
                    <div class="seletor-dia">
                        <button class="botao-dia" data-dia="segunda">Seg</button>
                        <button class="botao-dia" data-dia="terca">Ter</button>
                        <button class="botao-dia" data-dia="quarta">Qua</button>
                        <button class="botao-dia" data-dia="quinta">Qui</button>
                        <button class="botao-dia" data-dia="sexta">Sex</button>
                        <button class="botao-dia" data-dia="sabado">Sáb</button>
                        <button class="botao-dia" data-dia="domingo">Dom</button>
                    </div>
                </div>

                <div class="grupo-entrada">
                    <strong>Horário de Atendimento</strong>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <span
                                style="font-size: 0.6rem; color: var(--texto-suave); display: block; margin-bottom: 4px;">INÍCIO</span>
                            <input type="time" value="09:00">
                        </div>
                        <div>
                            <span
                                style="font-size: 0.6rem; color: var(--texto-suave); display: block; margin-bottom: 4px;">TÉRMINO</span>
                            <input type="time" value="18:00">
                        </div>
                    </div>
                </div>

                <button style="background: var(--primaria); 
                                color: white; 
                                border: none; 
                                padding: 14px; 
                                width: 100%;
                                border-radius: 8px; 
                                font-weight: 700; 
                                cursor: pointer; 
                                margin-top: auto; 
                                transition: 0.3s;
                                " onmouseover="this.style.opacity='0.9'
                                " onmouseout="this.style.opacity='1'">SALVAR CONFIGURAÇÕES</button>
            </div>

            <div id="notificacaoSalvo" style="
                                            position: fixed;
                                            bottom: 20px;
                                            right: 20px;
                                            background: #10b981;
                                            color: white;
                                            padding: 12px 18px;
                                            border-radius: 8px;
                                            font-weight: 600;
                                            display: none;
                                            z-index: 999;
                                            ">
                Configuração salva com sucesso
            </div>

            <div class="cartao">
                <h2>Calendário Mensal</h2>
                <p class="descricao-metricas">
                    Visualize todos os atendimentos agendados. É possível navegar por dia, semana ou mês para acompanhar
                    a agenda do salão em tempo real.
                </p>
                <div id="calendarioMini"></div>
            </div>
        </div>

        <div class="painel-metricas">
            <div class="cartao-metricas">
                <span
                    style="font-size: 0.65rem; font-weight: 800; color: var(--texto-suave); text-transform: uppercase;">Faturamento
                    Bruto</span>
                <h2 id="valor-metricas">R$ 0,00</h2>
                <p class="descricao-metricas">Total de vendas de serviços e produtos realizados no período atual.</p>
            </div>

            <div class="cartao-metricas">
                <span style="font-size:0.65rem;font-weight:800;color:var(--texto-suave);text-transform:uppercase;">
                    Ticket Médio
                </span>
                <div class="valor-metricas" id="valorTicket">R$ 0,00</div>
                <p class="descricao-metricas">Valor médio gasto por cada cliente em cada visita ao salão.</p>
            </div>

            <div class="cartao-metricas">
                <span style="font-size:0.65rem;font-weight:800;color:var(--texto-suave);text-transform:uppercase;">
                    Taxa de Ocupação
                </span>
                <div class="valor-metricas" id="valorOcupacao">0%</div>
                <p class="descricao-metricas">Porcentagem de horários preenchidos versus horários disponíveis.</p>
            </div>
        </div>

        <div class="grid-graficos">
            <div class="cartao">
                <h2>Ranking de Serviços</h2>
                <div class="filtros-grafico" id="filtrosServico">
                    <button class="botao-filtro ativo" data-categoria="manicure"
                        onclick="atualizarGraficoServico('manicure', event)">Manicure</button>
                    <button class="botao-filtro" data-categoria="massoterapia"
                        onclick="atualizarGraficoServico('massoterapia', event)">Massa.</button>
                    <button class="botao-filtro" data-categoria="depilacao"
                        onclick="atualizarGraficoServico('depilacao', event)">Depilação</button>
                    <button class="botao-filtro" data-categoria="lash"
                        onclick="atualizarGraficoServico('lash', event)">Lash</button>
                    <button class="botao-filtro" data-categoria="estetica"
                        onclick="atualizarGraficoServico('estetica', event)">Estética</button>
                    <button class="botao-filtro" data-categoria="todos"
                        onclick="atualizarGraficoServico('todos', event)">Todos</button>
                </div>
                <div class="container-grafico">
                    <canvas id="graficoServicos"></canvas>
                </div>
            </div>

            <div class="cartao">
                <h2>Performance Temporal</h2>

                <p class="descricao-metricas">
                    Mostra quanto o salão fatura em média em cada dia da semana, ajudando a identificar os dias mais
                    movimentados.
                </p>

                <div class="container-grafico">
                    <canvas id="graficoFaturamento"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>

        // ===== Listeners =====
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll(".botao-dia").forEach(botao => {

                botao.addEventListener("click", function () {

                    this.classList.toggle("ativo");

                });

            });

            const calendario = new FullCalendar.Calendar(document.getElementById('calendarioMini'), {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                height: 380,
                headerToolbar: {
                    left: 'prev',
                    center: 'title, dayGridMonth,timeGridWeek,timeGridDay',
                    right: 'next'
                },
                buttonText: {
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                dayMaxEvents: true
            });

            calendario.render();

            calendario.render();

            carregarDisponibilidade();

            document.querySelector("button").addEventListener("click", salvarConfiguracoes);


            const mes = document.getElementById("filtroMes").value;
            const ano = document.getElementById("filtroAno").value;

            carregarFaturamento(mes, ano);


            atualizarGraficoServico('todos', null);
            inicializarGraficoLinha();
        });

        function aplicarFiltrosGlobais() {

            const mes = document.getElementById('filtroMes').value;
            const ano = document.getElementById('filtroAno').value;

            carregarDisponibilidade(mes, ano);

            carregarFaturamento(mes, ano);

            carregarTicketMedio(mes, ano);

            carregarTaxaOcupacao(mes, ano);

            atualizarGraficoServico("todos");

            inicializarGraficoLinha();

        }

        document.addEventListener("DOMContentLoaded", function () {

            aplicarFiltrosGlobais();

        });

        // ===== Salvar configurações =====

        function salvarConfiguracoes() {

            const tipo = document.querySelector(".botao-tipo.ativo").dataset.tipo;

            const dias = [];

            document.querySelectorAll(".botao-dia.ativo").forEach(btn => {
                dias.push(btn.dataset.dia);
            });

            if (dias.length === 0) {
                alert("Selecione pelo menos um dia da semana");
                return;
            }

            const inicio = document.querySelectorAll("input[type=time]")[0].value;
            const fim = document.querySelectorAll("input[type=time]")[1].value;

            const mes = document.getElementById("filtroMes").value;
            const ano = document.getElementById("filtroAno").value;

            fetch("../api/agendamento/salvar_disponibilidade.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    tipo,
                    dias,
                    inicio,
                    fim,
                    mes,
                    ano
                })
            })
                .then(res => res.json())
                .then(res => {

                    console.log(res);

                    if (res.sucesso) {

                        alert("Configuração salva!");

                        carregarDisponibilidade(mes, ano);

                    } else {

                        alert("Erro: " + res.erro);

                    }

                })
                .catch(err => {

                    console.error(err);
                    alert("Erro ao conectar com o servidor");

                });

        }

        function mostrarNotificacaoSalvo() {

            const n = document.getElementById("notificacaoSalvo");

            n.style.display = "block";

            setTimeout(() => {
                n.style.display = "none";
            }, 3000);

        }
        // ===== Funções de calendário =====

        let calendario;
        function carregarDisponibilidade(mes = null, ano = null) {
            mes = mes || document.getElementById('filtroMes').value;
            ano = ano || document.getElementById('filtroAno').value;

            fetch(`../api/agendamento/buscar_disponibilidade_admin.php?mes=${mes}&ano=${ano}`)
                .then(res => res.json())
                .then(dados => {
                    const eventos = [];
                    dados.forEach(item => {
                        if (item.tipo === 'folga') eventos.push({ title: "Fechado", start: item.dia, allDay: true, color: "#ef4444" });
                        else eventos.push({ title: `Disponível: ${item.inicio} - ${item.fim}`, start: item.dia, allDay: true, color: "#10b981" });
                    });
                    if (calendario) {
                        calendario.removeAllEvents();
                        calendario.addEventSource(eventos);
                    }
                });
        }

        function carregarFaturamento(mes, ano) {

            fetch(`../api/relatorios/buscar_faturamento.php?mes=${mes}&ano=${ano}`)
                .then(res => res.json())
                .then(d => {

                    let total = d.total ?? 0;

                    document.getElementById("valorFaturamento").innerText =
                        `R$ ${Number(total).toLocaleString("pt-BR", { minimumFractionDigits: 2 })}`;

                })
                .catch(() => {
                    document.getElementById("valorFaturamento").innerText = "R$ 0,00";
                });

        }

        function carregarTicketMedio(mes, ano) {

            fetch(`../api/relatorios/buscar_ticket_medio.php?mes=${mes}&ano=${ano}`)
                .then(res => res.json())
                .then(d => {

                    let ticket = d.ticket ?? 0;

                    document.getElementById("valorTicket").innerText =
                        `R$ ${Number(ticket).toLocaleString("pt-BR", { minimumFractionDigits: 2 })}`;

                });

        }

        function carregarTaxaOcupacao(mes, ano) {

            fetch(`../api/relatorios/buscar_taxa_ocupacao.php?mes=${mes}&ano=${ano}`)
                .then(r => r.json())
                .then(d => {

                    let taxa = d.taxa ?? 0;

                    document.getElementById("valorOcupacao").innerText =
                        taxa + "%";

                });

        }

        const dadosServicos = {
            manicure: { nome: "Manicure", cor: "#4B1FA1", servicos: [{ nome: "Manicure", vol: 85 }, { nome: "Pedicure", vol: 60 }, { nome: "Alongamento", vol: 45 }, { nome: "Banho de gel", vol: 30 }, { nome: "Esmaltação perm.", vol: 25 }, { nome: "Spa dos pés", vol: 15 }] },
            massoterapia: { nome: "Massoterapia", cor: "#6b3fc9", servicos: [{ nome: "M. Relaxante", vol: 40 }, { nome: "M. Terapêutica", vol: 20 }, { nome: "Drenagem", vol: 25 }, { nome: "Bandagem", vol: 10 }, { nome: "Pós Parto", vol: 12 }] },
            depilacao: { nome: "Depilação", cor: "#d9b3ff", servicos: [{ nome: "Buço", vol: 50 }, { nome: "Sobrancelha", vol: 90 }, { nome: "Rosto", vol: 15 }, { nome: "Axilas", vol: 70 }, { nome: "Meia Perna", vol: 30 }, { nome: "Perna Int.", vol: 20 }, { nome: "Virilha Simp.", vol: 40 }, { nome: "Virilha Comp.", vol: 35 }] },
            lash: { nome: "Lash", cor: "#a78bfa", servicos: [{ nome: "Extensão Cílios", vol: 30 }, { nome: "Design Sobr.", vol: 55 }] },
            estetica: { nome: "Estética", cor: "#8b5cf6", servicos: [{ nome: "Preenchimento", vol: 5 }, { nome: "Botox", vol: 8 }, { nome: "Vasinhos", vol: 12 }, { nome: "Enzimas", vol: 15 }] }
        };

        let graficoBarras;

        // ===== Funções de interface =====
        function alternarTipo(btn) {
            document.querySelectorAll('.botao-tipo').forEach(b => b.classList.remove('ativo'));
            btn.classList.add('ativo');
        }

        // ===== Funções de gráficos =====
        function atualizarGraficoServico(categoria, evento) {

            const botoes = document.querySelectorAll('.botao-filtro');
            botoes.forEach(btn => btn.classList.remove('ativo'));

            if (evento && evento.target) {
                evento.target.classList.add('ativo');
            }

            const mes = document.getElementById("filtroMes").value;
            const ano = document.getElementById("filtroAno").value;

            fetch(`../api/relatorios/buscar_servicos_ranking.php?mes=${mes}&ano=${ano}`)
                .then(r => r.json())
                .then(dados => {

                    const rotulos = [];
                    const valores = [];
                    const cores = [];

                    dados.forEach(s => {

                        rotulos.push(s.servico);
                        valores.push(s.total);

                        cores.push("#8b5cf6"); // cor padrão do gráfico

                    });

                    if (graficoBarras) graficoBarras.destroy();

                    const ctx = document.getElementById('graficoServicos').getContext('2d');

                    graficoBarras = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: rotulos,
                            datasets: [{
                                data: valores,
                                backgroundColor: cores,
                                borderRadius: 4
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => ` Atendimentos: ${ctx.raw}`
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: { display: false },
                                    ticks: { font: { size: 10 } }
                                },
                                y: {
                                    grid: { display: false },
                                    ticks: { font: { size: 10, weight: '600' } }
                                }
                            }
                        }
                    });

                });

        }

        let graficoLinha;

        function inicializarGraficoLinha() {

            const mes = document.getElementById("filtroMes").value;
            const ano = document.getElementById("filtroAno").value;

            fetch(`../api/relatorios/buscar_faturamento_semana.php?mes=${mes}&ano=${ano}`)
                .then(r => r.json())
                .then(d => {

                    const dados = [
                        d[2] || 0,
                        d[3] || 0,
                        d[4] || 0,
                        d[5] || 0,
                        d[6] || 0,
                        d[7] || 0
                    ];

                    if (graficoLinha) graficoLinha.destroy();

                    const ctx = document.getElementById('graficoFaturamento').getContext('2d');

                    graficoLinha = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                            datasets: [{
                                label: 'Faturamento R$',
                                data: dados,
                                borderColor: '#4B1FA1',
                                tension: 0.4,
                                fill: true,
                                backgroundColor: 'rgba(75, 31, 161, 0.05)',
                                pointRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: ctx => "R$ " + ctx.raw.toLocaleString("pt-BR")
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: value => "R$ " + value
                                    }
                                },
                                x: {
                                    grid: { display: false }
                                }
                            }
                        }
                    });

                });

        }
    </script>
</body>

</html>
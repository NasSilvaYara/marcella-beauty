<?php
/*
===========================================================
ARQUIVO: agenda_completa.php

FUNÇÃO:
1. Salvar a disponibilidade do admin para o mês inteiro
2. Retornar resumo da agenda

===========================================================
*/

header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["sucesso" => false, "erro" => "Erro de conexão: " . $conn->connect_error]);
    exit;
}

// Recebe dados JSON
$data = json_decode(file_get_contents("php://input"), true);

$diasSemana = $data['dias'] ?? [];
$inicio = $data['inicio'] ?? "09:00";
$fim = $data['fim'] ?? "17:00";
$mes = intval($data['mes'] ?? date("n"));
$ano = intval($data['ano'] ?? date("Y"));
$modo = $data['modo'] ?? 'padrao'; // padrao ou excecao
$dataPontual = $data['dataPontual'] ?? null;

// Remove agenda existente do mês
$conn->query("DELETE FROM agenda WHERE MONTH(data) = $mes AND YEAR(data) = $ano");

// Mapa dias da semana
$mapa = [
    1 => "segunda",
    2 => "terca",
    3 => "quarta",
    4 => "quinta",
    5 => "sexta",
    6 => "sabado",
    7 => "domingo"
];

$diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

$agendaCompleta = [];
$totalTrabalho = 0;
$totalFolga = 0;
$totalHorarios = 0;

for ($dia = 1; $dia <= $diasMes; $dia++) {
    $dataFormatada = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
    $numeroSemana = date('N', strtotime($dataFormatada)); // 1-7
    $diaSemana = $mapa[$numeroSemana];

    $tipo = "folga";
    $horariosDia = [];

    // Verifica se é dia de trabalho
    if (($modo === 'padrao' && in_array($numeroSemana, $diasSemana)) || ($modo === 'excecao' && $dataFormatada === $dataPontual)) {
        $tipo = "trabalho";
        $horaAtual = strtotime($inicio);
        $horaFim = strtotime($fim);

        while ($horaAtual < $horaFim) {
            $horaInicioDia = date("H:i:s", $horaAtual);
            $duracao = 60;
            $status = 'disponivel';

            $stmt = $conn->prepare("INSERT INTO agenda (data, hora_inicio, duracao, status) VALUES (?, ?, ?, ?)");
            if (!$stmt) {
                echo json_encode(["sucesso" => false, "erro" => $conn->error]);
                exit;
            }
            $stmt->bind_param("ssis", $dataFormatada, $horaInicioDia, $duracao, $status);
            if (!$stmt->execute()) {
                echo json_encode(["sucesso" => false, "erro" => $stmt->error]);
                exit;
            }

            $horariosDia[] = $horaInicioDia;
            $horaAtual = strtotime("+1 hour", $horaAtual);
            $totalHorarios++;
        }
        $totalTrabalho++;
    } else {
        $totalFolga++;
    }

    $agendaCompleta[] = [
        "dia" => $dataFormatada,
        "tipo" => $tipo,
        "horarios" => $horariosDia
    ];
}

// Resumo final
$resumo = [
    "total_dias_trabalho" => $totalTrabalho,
    "total_dias_folga" => $totalFolga,
    "total_horarios" => $totalHorarios
];

echo json_encode([
    "sucesso" => true,
    "agenda" => $agendaCompleta,
    "resumo" => $resumo
]);
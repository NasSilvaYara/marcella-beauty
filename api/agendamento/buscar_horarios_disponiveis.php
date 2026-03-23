/*
===========================================================
ARQUIVO: buscar_horarios_disponiveis.php

FUNÇÃO:
Responsável por retornar os horários disponíveis
para um dia específico.

COMO FUNCIONA:
1. Recebe:
   - data (YYYY-MM-DD)
   - duração do serviço (em minutos)

2. Busca na tabela "disponibilidade":
   - horário de início e fim do expediente

3. Busca na tabela "agendamentos":
   - horários já ocupados

4. Gera horários de 15 em 15 minutos

5. Filtra:
   - remove horários que não cabem na duração
   - remove horários que entram em conflito com outros agendamentos

RETORNO:
Exemplo:
["09:00", "09:15", "11:00", "14:30"]

USO:
- Mostrar horários clicáveis no front-end

IMPORTANTE:
Toda a lógica de disponibilidade + conflito está aqui.
O front-end apenas exibe o resultado.
===========================================================
*/

<?php
require_once "../config/db_config.php";

$duracao = isset($_GET['duracao']) ? intval($_GET['duracao']) : 0;

$data = $_GET['data'];

$diaSemana = strtolower(date('l', strtotime($data)));

$mapa = [
    "monday" => "segunda",
    "tuesday" => "terca",
    "wednesday" => "quarta",
    "thursday" => "quinta",
    "friday" => "sexta",
    "saturday" => "sabado",
    "sunday" => "domingo"
];

$diaSemanaPT = $mapa[$diaSemana];

$sql = $conn->prepare("SELECT * FROM disponibilidade WHERE dia_semana = ?");
$sql->execute([$diaSemanaPT]);
$regra = $sql->fetch(PDO::FETCH_ASSOC);

if (!$regra || $regra['tipo'] === 'folga') {
    echo json_encode([]);
    exit;
}

$sql2 = $conn->prepare("SELECT hora_inicio, duracao FROM agendamentos WHERE data = ?");
$sql2->execute([$data]);
$agendamentos = $sql2->fetchAll(PDO::FETCH_ASSOC);

$inicio = strtotime($regra['hora_inicio']);
$fim = strtotime($regra['hora_fim']);

$horarios = [];

for ($h = $inicio; $h <= ($fim - ($duracao * 60)); $h += 15 * 60) {

    $horaAtual = date("H:i", $h);
    $minAtual = strtotime($horaAtual);

    $ocupado = false;

    foreach ($agendamentos as $ag) {
        $inicioAg = strtotime($ag['hora_inicio']);
        $fimAg = $inicioAg + ($ag['duracao'] * 60);

        $fimTeste = $minAtual + ($duracao * 60);

        if ($minAtual < $fimAg && $fimTeste > $inicioAg) {
            $ocupado = true;
            break;
        }
    }

    if (!$ocupado) {
        $horarios[] = $horaAtual;
    }
}

echo json_encode($horarios);
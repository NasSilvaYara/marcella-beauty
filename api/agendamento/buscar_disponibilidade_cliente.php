/*
===========================================================
ARQUIVO: buscar_disponibilidade_cliente.php

FUNÇÃO:
Este arquivo é responsável por informar ao FRONT-END
quais dias do mês estão disponíveis para agendamento.

COMO FUNCIONA:
- Recebe mês e ano via GET
- Percorre todos os dias do mês
- Consulta a tabela "disponibilidade"
- Verifica se o dia da semana está como:
    - trabalho → disponível
    - folga → indisponível

RETORNO:
Retorna um JSON no formato:
{
  "2026-03-10": true,
  "2026-03-11": false
}

USO:
Utilizado no calendário do cliente para:
- liberar dias clicáveis
- bloquear dias fechados

OBS:
Não verifica horários nem agendamentos.
Apenas define se o DIA está aberto ou fechado.
===========================================================
*/

<?php
require_once "../config/db_config.php";

$mes = $_GET['mes'];
$ano = $_GET['ano'];

$diasNoMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

$resultado = [];

for ($dia = 1; $dia <= $diasNoMes; $dia++) {

    $data = "$ano-" . str_pad($mes, 2, "0", STR_PAD_LEFT) . "-" . str_pad($dia, 2, "0", STR_PAD_LEFT);

    $diaSemana = strtolower(date('l', strtotime($data)));

    // traduz inglês → português
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

    // busca regra do admin
    $sql = $conn->prepare("SELECT * FROM disponibilidade WHERE dia_semana = ?");
    $sql->execute([$diaSemanaPT]);
    $regra = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$regra || $regra['tipo'] === 'folga') {
        $resultado[$data] = false;
    } else {
        $resultado[$data] = true;
    }
}

echo json_encode($resultado);
/*
===========================================================
ARQUIVO: buscar_disponibilidade_admin.php

FUNÇÃO:
Retornar a configuração de disponibilidade criada pelo admin.

COMO FUNCIONA:
- Busca registros da tabela "disponibilidade"
- Retorna dias configurados como:
    - trabalho
    - folga

RETORNO:
Lista de objetos com:
- tipo (trabalho/folga)
- dia
- horário início/fim

USO:
- Alimenta o calendário do painel admin
- Permite visualizar dias abertos/fechados

OBS:
Não calcula horários disponíveis.
Apenas mostra regras cadastradas.
===========================================================
*/

<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost","root","","marcella_beauty");

if($conn->connect_error){
    echo json_encode([]);
    exit;
}

$mes = intval($_GET['mes'] ?? date("n"));
$ano = intval($_GET['ano'] ?? date("Y"));

// Descobre quantos dias tem o mês
$diasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

// Busca regras de disponibilidade
$sql = "SELECT * FROM disponibilidade WHERE mes=? AND ano=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$mes,$ano);
$stmt->execute();
$res = $stmt->get_result();

// Monta array de regras por dia da semana
$regras = [];
while($row = $res->fetch_assoc()){
    $regras[$row['dia_semana']] = [
        "tipo" => $row['tipo'],
        "hora_inicio" => $row['hora_inicio'],
        "hora_fim" => $row['hora_fim']
    ];
}

$resultado = [];

$mapa = [
    1 => "segunda",
    2 => "terca",
    3 => "quarta",
    4 => "quinta",
    5 => "sexta",
    6 => "sabado",
    7 => "domingo"
];

for($dia=1; $dia<=$diasMes; $dia++){

    $data = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
    $numeroSemana = date("N", strtotime($data));
    $diaSemana = $mapa[$numeroSemana];

    if(isset($regras[$diaSemana])){
        $diaFinal = [
            "tipo" => $regras[$diaSemana]['tipo'],
            "dia" => $data,
            "inicio" => $regras[$diaSemana]['hora_inicio'],
            "fim" => $regras[$diaSemana]['hora_fim']
        ];
    } else {
        $diaFinal = [
            "tipo" => "folga",
            "dia" => $data,
            "inicio" => null,
            "fim" => null
        ];
    }

    $resultado[] = $diaFinal;
}

echo json_encode($resultado);
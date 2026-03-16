<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost","root","","marcella_beauty");

if($conn->connect_error){
    echo json_encode(["erro"=>"Erro conexão"]);
    exit;
}

$mes = intval($_GET['mes']);
$ano = intval($_GET['ano']);


// ATENDIMENTOS CONFIRMADOS
$sql = "SELECT COUNT(id) as atendimentos
FROM agenda
WHERE MONTH(data)=?
AND YEAR(data)=?
AND status='confirmado'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$mes,$ano);
$stmt->execute();

$res = $stmt->get_result()->fetch_assoc();
$atendimentos = $res["atendimentos"] ?? 0;



// DISPONIBILIDADE CONFIGURADA
$sql = "SELECT dia_semana,hora_inicio,hora_fim,intervalo_minutos
FROM disponibilidade
WHERE ativo=1";

$res = $conn->query($sql);

$totalDisponivel = 0;

while($row = $res->fetch_assoc()){

$diaSemana = $row["dia_semana"];

$inicio = strtotime($row["hora_inicio"]);
$fim = strtotime($row["hora_fim"]);
$intervalo = $row["intervalo_minutos"] * 60;


// QUANTOS HORÁRIOS EXISTEM NESSE DIA
$horariosDia = floor(($fim - $inicio) / $intervalo);


// CONTAR QUANTAS VEZES ESSE DIA EXISTE NO MÊS
$diasMes = cal_days_in_month(CAL_GREGORIAN,$mes,$ano);

$contador = 0;

for($d=1;$d<=$diasMes;$d++){

$data = "$ano-$mes-$d";

$diaSemanaData = strtolower(date("l",strtotime($data)));

$mapa = [
"monday"=>"segunda",
"tuesday"=>"terca",
"wednesday"=>"quarta",
"thursday"=>"quinta",
"friday"=>"sexta",
"saturday"=>"sabado",
"sunday"=>"domingo"
];

if($mapa[$diaSemanaData] == $diaSemana){
$contador++;
}

}

$totalDisponivel += $horariosDia * $contador;

}



// CALCULAR TAXA
$taxa = 0;

if($totalDisponivel > 0){
$taxa = ($atendimentos / $totalDisponivel) * 100;
}

echo json_encode([
"taxa"=>round($taxa,1)
]);
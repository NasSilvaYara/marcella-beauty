<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro conexão"]);
    exit;
}

$mes = $_GET['mes'];
$ano = $_GET['ano'];

$sql = "SELECT 
SUM(valor_total) as faturamento,
COUNT(id) as atendimentos
FROM agenda
WHERE MONTH(data) = ?
AND YEAR(data) = ?
AND status = 'confirmado'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mes, $ano);
$stmt->execute();

$res = $stmt->get_result()->fetch_assoc();

$faturamento = $res["faturamento"] ?? 0;
$atendimentos = $res["atendimentos"] ?? 0;

$ticket = 0;

if ($atendimentos > 0) {
    $ticket = $faturamento / $atendimentos;
}

echo json_encode([
    "ticket" => $ticket
]);
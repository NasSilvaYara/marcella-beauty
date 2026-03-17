<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro conexão"]);
    exit;
}

$mes = $_GET['mes'];
$ano = $_GET['ano'];

$sql = "SELECT DAYOFWEEK(data) as dia, SUM(valor_total) as total
FROM agenda
WHERE MONTH(data)=?
AND YEAR(data)=?
AND status='confirmado'
GROUP BY dia";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mes, $ano);
$stmt->execute();

$res = $stmt->get_result();

$dias = [
    1 => 0,
    2 => 0,
    3 => 0,
    4 => 0,
    5 => 0,
    6 => 0,
    7 => 0
];

while ($row = $res->fetch_assoc()) {
    $dias[$row["dia"]] = $row["total"];
}

echo json_encode($dias);
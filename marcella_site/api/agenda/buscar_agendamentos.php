<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro conexão"]);
    exit;
}

$sql = "SELECT id, cliente_nome, data, hora_inicio, duracao, servicos, status
FROM agenda
WHERE status != 'cancelado'";

$res = $conn->query($sql);

$eventos = [];

while ($row = $res->fetch_assoc()) {

    $inicio = $row["data"] . "T" . $row["hora_inicio"];

    $fim = date(
        "Y-m-d\TH:i:s",
        strtotime($row["data"] . " " . $row["hora_inicio"] . " +" . $row["duracao"] . " minutes")
    );

    $eventos[] = [
        "id" => $row["id"],
        "title" => $row["cliente_nome"] . " - " . $row["servicos"],
        "start" => $inicio,
        "end" => $fim,
        "color" => $row["status"] == "confirmado" ? "#8b5cf6" : "#f59e0b"
    ];

}

echo json_encode($eventos);
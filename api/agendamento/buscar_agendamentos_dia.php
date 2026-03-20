<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode([]);
    exit;
}

$data = $_GET['data'];

$sql = "SELECT hora_inicio, duracao 
        FROM agenda 
        WHERE data = '$data' 
        AND status != 'cancelado'";

$res = $conn->query($sql);

$lista = [];

while ($row = $res->fetch_assoc()) {
    $lista[] = $row;
}

echo json_encode($lista);
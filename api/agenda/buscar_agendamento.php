<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro conexão"]);
    exit;
}

$id = $_GET["id"] ?? null;

if (!$id) {
    echo json_encode(["erro" => "ID não informado"]);
    exit;
}

$stmt = $conn->prepare("
SELECT 
id,
cliente_nome,
cliente_telefone,
data,
hora_inicio,
duracao,
servicos,
valor_total,
status
FROM agenda
WHERE id=?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$res = $stmt->get_result();

if ($res->num_rows == 0) {
    echo json_encode(["erro" => "Agendamento não encontrado"]);
    exit;
}

echo json_encode($res->fetch_assoc());
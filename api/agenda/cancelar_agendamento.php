<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

$id = $_POST["id"] ?? null;

if (!$id) {
    echo json_encode(["erro" => "ID não informado"]);
    exit;
}

$stmt = $conn->prepare("UPDATE agenda SET status='cancelado' WHERE id=?");

$stmt->bind_param("i", $id);

$stmt->execute();

echo json_encode(["sucesso" => true]);
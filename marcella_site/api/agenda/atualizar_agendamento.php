<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost","root","","marcella_beauty");

$dados = json_decode(file_get_contents("php://input"), true);
$id = $dados['id'] ?? null;
$data = $dados['data'] ?? null;
$hora = $dados['hora_inicio'] ?? null;
$duracao = $dados['duracao'] ?? null;

if(!$id || !$data || !$hora || !$duracao){
    echo json_encode(["erro"=>"Dados incompletos"]);
    exit;
}

$stmt = $conn->prepare("
UPDATE agenda 
SET data=?, hora_inicio=?, duracao=? 
WHERE id=?
");
$stmt->bind_param("ssii", $data, $hora, $duracao, $id);
$stmt->execute();

echo json_encode(["sucesso"=>true]);
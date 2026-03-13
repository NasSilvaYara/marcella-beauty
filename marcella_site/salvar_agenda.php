<?php
session_start();
include 'conexao.php'; // Seu arquivo de conexão com o banco

// Segurança: Se não for a Marcella, bloqueia o acesso direto ao script
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== "marcella@exemplo.com") {
    die(json_encode(["status" => "erro", "msg" => "Acesso negado"]));
}

// Recebe os dados enviados pelo JavaScript (JSON)
$dados = json_decode(file_get_contents('php://input'), true);

$data = $dados['data'];    // Ex: 2026-03-15
$hora = $dados['hora'];    // Ex: 14:30
$acao = $dados['acao'];    // 'adicionar' ou 'remover'

if ($acao === 'adicionar') {
    $sql = "INSERT INTO agenda_disponivel (data_disponivel, hora_disponivel, status, categoria) 
            VALUES (?, ?, 'livre', 'administrado')";
} else {
    $sql = "DELETE FROM agenda_disponivel WHERE data_disponivel = ? AND hora_disponivel = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $data, $hora);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso"]);
} else {
    echo json_encode(["status" => "erro", "msg" => $conn->error]);
}
?>
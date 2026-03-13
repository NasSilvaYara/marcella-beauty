<?php
session_start();
include 'conexao.php'; // Certifique-se que este arquivo existe e conecta ao seu DB

// 1. SEGURANÇA: Só a Marcella entra aqui
$emailAdmin = "marcella@exemplo.com"; 
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== $emailAdmin) {
    echo json_encode(["status" => "erro", "message" => "Acesso negado"]);
    exit;
}

// 2. RECEBIMENTO: Pegamos o JSON enviado pelo JS
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data || !isset($data['data'])) {
    echo json_encode(["status" => "erro", "message" => "Dados inválidos"]);
    exit;
}

$dataSelecionada = $data['data'];      // Ex: 2026-03-15
$horariosNovos = $data['horarios'];   // Ex: ["09:00", "10:30", "15:00"]

// 3. TRANSAÇÃO: Vamos limpar e regravar
// Usamos transação para garantir que, se um falhar, nada mude.
$conn->begin_transaction();

try {
    // Primeiro: Remove tudo o que existia nesse dia para a categoria administrada
    $sqlDelete = "DELETE FROM agenda_disponivel WHERE data_disponivel = ? AND categoria = 'administrado'";
    $stmtDel = $conn->prepare($sqlDelete);
    $stmtDel->bind_param("s", $dataSelecionada);
    $stmtDel->execute();

    // Segundo: Insere os horários da nova lista
    if (!empty($horariosNovos)) {
        $sqlInsert = "INSERT INTO agenda_disponivel (data_disponivel, hora_disponivel, status, categoria) VALUES (?, ?, 'livre', 'administrado')";
        $stmtIns = $conn->prepare($sqlInsert);

        foreach ($horariosNovos as $hora) {
            $stmtIns->bind_param("ss", $dataSelecionada, $hora);
            $stmtIns->execute();
        }
    }

    $conn->commit();
    echo json_encode(["status" => "sucesso"]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["status" => "erro", "message" => $e->getMessage()]);
}

$conn->close();
?>
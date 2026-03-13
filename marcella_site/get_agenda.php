<?php
include 'conexao.php';

// Recebe o mês/ano que o usuário está visualizando no calendário (opcional para filtro)
$mes = $_GET['mes'] ?? date('m');
$ano = $_GET['ano'] ?? date('Y');

// Busca apenas os horários com status 'livre'
$sql = "SELECT data_disponivel, hora_disponivel FROM agenda_disponivel 
        WHERE status = 'livre' AND MONTH(data_disponivel) = ? AND YEAR(data_disponivel) = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $mes, $ano);
$stmt->execute();
$result = $stmt->get_result();

$agenda = [];
while ($row = $result->fetch_assoc()) {
    // Agrupa por data para facilitar a leitura do JS
    $agenda[$row['data_disponivel']][] = $row['hora_disponivel'];
}

echo json_encode($agenda);
?>
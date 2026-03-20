<?php
// 1️⃣ Conexão com o banco
include '../db_config.php';

// 2️⃣ Recebe os parâmetros da URL
$mes = isset($_GET['mes']) ? intval($_GET['mes']) : 0;
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : 0;

// 3️⃣ Validação simples
if ($mes < 1 || $mes > 12 || $ano < 2000) {
    echo json_encode([]);
    exit;
}

// 4️⃣ Query ao banco
$sql = "SELECT data, hora FROM agendamentos 
        WHERE MONTH(data) = $mes AND YEAR(data) = $ano
        ORDER BY data, hora";

$result = $conn->query($sql);

// 5️⃣ Monta array para JSON
$agenda = [];
while($row = $result->fetch_assoc()) {
    $agenda[$row['data']][] = $row['hora'];
}

// 6️⃣ Retorna JSON
echo json_encode($agenda);
?>
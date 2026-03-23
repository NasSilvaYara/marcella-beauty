/*
===========================================================
ARQUIVO: get_agenda.php

FUNÇÃO:
Retornar agendamentos existentes de um mês.

COMO FUNCIONA:
- Recebe mês e ano
- Busca na tabela "agendamentos"
- Agrupa por data

RETORNO:
{
  "2026-03-10": ["09:00", "10:00"],
  "2026-03-11": ["14:00"]
}

USO:
- Pode ser usado para relatórios
- Pode ser usado para dashboards

OBS:
Não controla disponibilidade.
Apenas lista horários já ocupados.
===========================================================
*/

<?php

include '../db_config.php';

$mes = isset($_GET['mes']) ? intval($_GET['mes']) : 0;
$ano = isset($_GET['ano']) ? intval($_GET['ano']) : 0;

if ($mes < 1 || $mes > 12 || $ano < 2000) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT data, hora FROM agendamentos 
        WHERE MONTH(data) = $mes AND YEAR(data) = $ano
        ORDER BY data, hora";

$result = $conn->query($sql);

$agenda = [];
while($row = $result->fetch_assoc()) {
    $agenda[$row['data']][] = $row['hora'];
}

echo json_encode($agenda);
?>
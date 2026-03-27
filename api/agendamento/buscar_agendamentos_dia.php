/*
===========================================================
ARQUIVO: buscar_agendamentos_data.php

FUNÇÃO:
Retornar os agendamentos já existentes em uma data específica.

COMO FUNCIONA:
- Recebe uma data via parâmetro GET
- Conecta ao banco de dados
- Consulta a tabela "agenda"
- Filtra registros pela data informada
- Ignora agendamentos com status "cancelado"
- Coleta horários já ocupados

RETORNO:
Lista de objetos contendo:
- hora_inicio (horário de início do agendamento)
- duracao (tempo total do serviço)

USO:
- Utilizado para bloquear horários já ocupados
- Auxilia no cálculo de horários disponíveis
- Integrado ao calendário de agendamento

OBS:
- Considera apenas agendamentos ativos
- Não retorna dados do cliente nem detalhes do serviço
- Pode ser otimizado com prepared statements (segurança)
===========================================================
*/

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
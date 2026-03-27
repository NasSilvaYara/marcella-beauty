/*
===========================================================
ARQUIVO: cancelar_agendamento.php

FUNÇÃO:
Cancelar um agendamento existente na agenda.

COMO FUNCIONA:
- Recebe o ID do agendamento via requisição POST
- Conecta ao banco de dados
- Valida se o ID foi informado
- Atualiza o status do agendamento para "cancelado"
- Não remove o registro, apenas altera seu estado

RETORNO:
Objeto JSON contendo:
- sucesso (true/false)
- erro (mensagem, se houver)

USO:
- Utilizado para cancelar agendamentos no sistema
- Permite manter histórico sem excluir dados
- Integrado ao painel admin ou interface do cliente

OBS:
- Usa prepared statement (mais seguro contra SQL Injection)
- O agendamento permanece no banco, apenas marcado como cancelado
- Pode ser filtrado em consultas futuras (ex: horários disponíveis)
===========================================================
*/

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
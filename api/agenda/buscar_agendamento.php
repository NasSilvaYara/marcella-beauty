/*
===========================================================
ARQUIVO: buscar_agendamento.php

FUNÇÃO:
Buscar os dados de um agendamento específico.

COMO FUNCIONA:
- Recebe o ID do agendamento via requisição GET
- Conecta ao banco de dados
- Valida se o ID foi informado
- Executa uma consulta usando prepared statement
- Busca o agendamento correspondente ao ID
- Retorna os dados encontrados

RETORNO:
Objeto JSON contendo:
- id
- cliente_nome
- cliente_telefone
- data
- hora_inicio
- duracao
- servicos
- valor_total
- status

OU:
- erro (mensagem, se não encontrado ou inválido)

USO:
- Utilizado para visualizar detalhes de um agendamento
- Pode ser usado em modais, edição ou visualização no sistema
- Integrado ao frontend via AJAX

OBS:
- Usa prepared statement (seguro contra SQL Injection)
- Retorna apenas um registro específico
- Retorna erro caso o ID não exista no banco
===========================================================
*/

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
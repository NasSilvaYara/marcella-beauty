/*
===========================================================
ARQUIVO: salvar_agendamento.php

FUNÇÃO:
Salvar um novo agendamento no banco de dados.

COMO FUNCIONA:

1. Recebe dados via JSON:
   - nome do cliente
   - telefone
   - data
   - hora
   - duração
   - serviços
   - valor total

2. Valida:
   - se os dados obrigatórios foram enviados

3. Verifica disponibilidade:
   - consulta tabela "disponibilidade"
   - bloqueia dias de folga

4. Verifica conflito:
   - busca agendamentos do mesmo dia
   - impede sobreposição de horários

5. Insere no banco:
   - salva na tabela "agendamentos"

RETORNO:
- { status: "ok" } → sucesso
- { status: "erro", mensagem: "..." }

SEGURANÇA:
Mesmo que o front-end falhe ou seja burlado,
o backend impede:
- horários duplicados
- agendamentos em dias fechados

OBS:
Este é o ponto mais crítico do sistema.
===========================================================
*/
<?php
require_once "../config/db_config.php";

header("Content-Type: application/json");

$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados não recebidos"]);
    exit;
}

$nome = $dados["cliente_nome"] ?? null;
$telefone = $dados["whatsapp"] ?? null;
$data = $dados["data"] ?? null;
$hora = $dados["hora_inicio"] ?? null;
$duracao = $dados["duracao"] ?? null;
$valor = $dados["valor_total"] ?? 0;
$servicosArray = $dados["servicos"] ?? [];

$servicos = implode(", ", $servicosArray);

$status = "confirmado";

if (!$nome || !$data || !$hora) {
    echo json_encode(["status" => "erro", "mensagem" => "Dados incompletos"]);
    exit;
}

$inicioNovo = strtotime("$data $hora");
$fimNovo = $inicioNovo + ($duracao * 60);

$sql = $conn->prepare("SELECT hora_inicio, duracao FROM agendamentos WHERE data = ?");
$sql->execute([$data]);

$agendamentos = $sql->fetchAll(PDO::FETCH_ASSOC);

foreach ($agendamentos as $ag) {

    $inicioExistente = strtotime("$data " . $ag['hora_inicio']);
    $fimExistente = $inicioExistente + ($ag['duracao'] * 60);

    if ($inicioNovo < $fimExistente && $fimNovo > $inicioExistente) {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Horário já ocupado"
        ]);
        exit;
    }
}

$stmt = $conn->prepare("INSERT INTO agendamentos 
    (cliente_nome, cliente_telefone, data, hora_inicio, duracao, servicos, valor_total, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$ok = $stmt->execute([
    $nome,
    $telefone,
    $data,
    $hora,
    $duracao,
    $servicos,
    $valor,
    $status
]);

if ($ok) {
    echo json_encode(["status" => "ok"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao salvar"]);
}

$diaSemana = strtolower(date('l', strtotime($data)));

$mapa = [
    "monday" => "segunda",
    "tuesday" => "terca",
    "wednesday" => "quarta",
    "thursday" => "quinta",
    "friday" => "sexta",
    "saturday" => "sabado",
    "sunday" => "domingo"
];

$diaSemanaPT = $mapa[$diaSemana];

$sql = $conn->prepare("SELECT * FROM disponibilidade WHERE dia_semana = ?");
$sql->execute([$diaSemanaPT]);

$regra = $sql->fetch(PDO::FETCH_ASSOC);

if (!$regra || $regra['tipo'] === 'folga') {
    echo json_encode([
        "status" => "erro",
        "mensagem" => "Este dia não está disponível para agendamento"
    ]);
    exit;
}
/*
===========================================================
ARQUIVO: atualizar_agendamento.php

FUNÇÃO:
Listar os agendamentos ativos da agenda.

COMO FUNCIONA:
- Conecta ao banco de dados
- Busca todos os agendamentos com status diferente de "cancelado"
- Percorre os registros retornados
- Monta a data/hora de início combinando "data" e "hora_inicio"
- Calcula a data/hora de término com base na duração
- Formata os dados no padrão de eventos (para calendário)
- Define cores diferentes conforme o status do agendamento

RETORNO:
Array JSON contendo:
- id
- title (nome do cliente + serviços)
- start (data/hora início)
- end (data/hora fim)
- color (cor do evento no calendário)

USO:
- Utilizado para alimentar calendários (ex: FullCalendar)
- Exibe apenas agendamentos ativos (não cancelados)
- Pode ser consumido via AJAX no frontend

OBS:
- Não altera dados no banco, apenas consulta
- O horário final é calculado dinamicamente
- Eventos confirmados têm cor roxa (#8b5cf6)
- Outros status usam cor amarela (#f59e0b)
===========================================================
*/

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
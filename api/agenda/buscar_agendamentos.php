/*
===========================================================
ARQUIVO: listar_eventos.php

FUNÇÃO:
Listar os agendamentos ativos formatados como eventos de calendário.

COMO FUNCIONA:
- Conecta ao banco de dados
- Busca todos os agendamentos com status diferente de "cancelado"
- Percorre os registros retornados do banco
- Monta a data/hora de início combinando "data" e "hora_inicio"
- Calcula a data/hora de término somando a duração do serviço
- Formata os dados no padrão esperado por bibliotecas de calendário
- Define uma cor para cada evento com base no status

RETORNO:
Array JSON contendo:
- id
- title (nome do cliente + serviços)
- start (data/hora início no formato ISO)
- end (data/hora fim no formato ISO)
- color (cor do evento)

USO:
- Utilizado para alimentar calendários (ex: FullCalendar)
- Exibe apenas agendamentos ativos
- Pode ser consumido via AJAX no frontend

OBS:
- Não altera dados no banco, apenas realiza leitura
- O horário final é calculado dinamicamente
- Eventos confirmados usam cor roxa (#8b5cf6)
- Demais eventos usam cor amarela (#f59e0b)
===========================================================
*/

<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro conexão"]);
    exit;
}

$sql = "SELECT id, cliente_nome, data, hora_inicio, duracao, servicos, status
FROM agenda
WHERE status != 'cancelado'";

$res = $conn->query($sql);

$eventos = [];

while ($row = $res->fetch_assoc()) {

    $inicio = $row["data"] . "T" . $row["hora_inicio"];

    $fim = date(
        "Y-m-d\TH:i:s",
        strtotime($row["data"] . " " . $row["hora_inicio"] . " +" . $row["duracao"] . " minutes")
    );

    $eventos[] = [
        "id" => $row["id"],
        "title" => $row["cliente_nome"] . " - " . $row["servicos"],
        "start" => $inicio,
        "end" => $fim,
        "color" => $row["status"] == "confirmado" ? "#8b5cf6" : "#f59e0b"
    ];

}

echo json_encode($eventos);
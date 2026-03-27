/*
===========================================================
ARQUIVO: salvar_disponiilidade.php

FUNÇÃO:
Gerar automaticamente a agenda de horários para um mês inteiro,
com base nos dias da semana e horários definidos pelo administrador.

COMO FUNCIONA:
- Recebe dados via requisição JSON (POST):
    - dias da semana permitidos
    - horário de início e fim
    - mês e ano
- Conecta ao banco de dados
- Remove todos os registros existentes da agenda no mês/ano informado
- Percorre todos os dias do mês:
    - Valida se a data existe
    - Verifica se o dia da semana está permitido
- Para cada dia válido:
    - Gera horários em intervalos de 1 hora
    - Insere cada horário na tabela "agenda"

RETORNO:
Objeto JSON contendo:
- sucesso (true/false)
- erro (mensagem, se houver)

USO:
- Utilizado no painel administrativo
- Permite criar rapidamente a agenda mensal
- Base para definição de horários disponíveis no sistema

OBS:
- Apaga completamente a agenda do mês antes de recriar
- Intervalo de horários é fixo em 1 hora
- Pode sobrescrever dados existentes (usar com cuidado)
- Utiliza prepared statements na inserção (mais seguro)
===========================================================
*/

<?php
header("Content-Type: application/json");
date_default_timezone_set('America/Sao_Paulo');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");
if ($conn->connect_error) {
    echo json_encode(["sucesso" => false, "erro" => "Erro conexão"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// Validar dados
$diasSemana = isset($data['dias']) ? $data['dias'] : [];
$inicio = isset($data['inicio']) ? $data['inicio'] : "08:00:00";
$fim = isset($data['fim']) ? $data['fim'] : "17:00:00";
$mes = isset($data['mes']) ? (int)$data['mes'] : date('m');
$ano = isset($data['ano']) ? (int)$data['ano'] : date('Y');

try {
    // Deletar registros existentes
    $stmtDel = $conn->prepare("DELETE FROM agenda WHERE MONTH(data) = ? AND YEAR(data) = ?");
    $stmtDel->bind_param("ii", $mes, $ano);
    $stmtDel->execute();
    $stmtDel->close();

    // Gerar agenda
    for ($dia = 1; $dia <= 31; $dia++) {
        if (!checkdate($mes, $dia, $ano)) continue;

        $dataFormatada = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
        $diaSemanaNumero = date('w', strtotime($dataFormatada));

        if (in_array($diaSemanaNumero, $diasSemana)) {
            $horaAtual = strtotime($inicio);
            $horaFim = strtotime($fim);

            while ($horaAtual < $horaFim) {
                $hora = date("H:i:s", $horaAtual);
                $stmt = $conn->prepare("INSERT INTO agenda (data, hora) VALUES (?, ?)");
                $stmt->bind_param("ss", $dataFormatada, $hora);
                $stmt->execute();
                $stmt->close();

                $horaAtual = strtotime("+1 hour", $horaAtual);
            }
        }
    }

    echo json_encode(["sucesso" => true]);
} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "erro" => $e->getMessage()]);
}
$conn->close();
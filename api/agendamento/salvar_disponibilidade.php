<?php
header("Content-Type: application/json");

// conexão com banco
$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["sucesso" => false, "erro" => "Erro conexão"]);
    exit;
}

// pega JSON
$data = json_decode(file_get_contents("php://input"), true);

$diasSemana = $data['dias'];
$inicio = $data['inicio'];
$fim = $data['fim'];
$mes = $data['mes'];
$ano = $data['ano'];

// limpa agenda do mês (opcional, mas recomendado)
$conn->query("DELETE FROM agenda WHERE MONTH(data) = $mes AND YEAR(data) = $ano");

// percorre o mês
for ($dia = 1; $dia <= 31; $dia++) {

    if (!checkdate($mes, $dia, $ano)) continue;

    $dataFormatada = sprintf("%04d-%02d-%02d", $ano, $mes, $dia);
    $diaSemanaNumero = date('w', strtotime($dataFormatada)); // 0=domingo

    if (in_array($diaSemanaNumero, $diasSemana)) {

        $horaAtual = strtotime($inicio);
        $horaFim = strtotime($fim);

        while ($horaAtual < $horaFim) {

            $hora = date("H:i:s", $horaAtual);

            $stmt = $conn->prepare("INSERT INTO agenda (data, hora) VALUES (?, ?)");
            $stmt->bind_param("ss", $dataFormatada, $hora);
            $stmt->execute();

            $horaAtual = strtotime("+1 hour", $horaAtual);
        }
    }
}

echo json_encode(["sucesso" => true]);
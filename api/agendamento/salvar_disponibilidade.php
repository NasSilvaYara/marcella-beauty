<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(['erro' => 'Erro de conexão']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['erro' => 'Dados inválidos']);
    exit;
}

$tipo = $data['tipo'];
$dias = $data['dias'];
$inicio = $data['inicio'];
$fim = $data['fim'];
$mes = intval($data['mes']);
$ano = intval($data['ano']);

$sucesso = true;

foreach ($dias as $dia) {

    // verificar se já existe regra
    $sql = "SELECT id FROM disponibilidade 
            WHERE dia_semana=? AND tipo=? AND mes=? AND ano=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $dia, $tipo, $mes, $ano);
    $stmt->execute();

    $res = $stmt->get_result();

    if ($res->num_rows > 0) {

        $row = $res->fetch_assoc();

        // atualizar
        $sql = "UPDATE disponibilidade 
                SET hora_inicio=?, hora_fim=? 
                WHERE id=?";

        $upd = $conn->prepare($sql);
        $upd->bind_param("ssi", $inicio, $fim, $row['id']);

        if (!$upd->execute()) {
            $sucesso = false;
        }

    } else {

        // inserir
        $sql = "INSERT INTO disponibilidade 
                (tipo, dia_semana, hora_inicio, hora_fim, mes, ano) 
                VALUES (?,?,?,?,?,?)";

        $ins = $conn->prepare($sql);
        $ins->bind_param("ssssii", $tipo, $dia, $inicio, $fim, $mes, $ano);

        if (!$ins->execute()) {
            $sucesso = false;
        }

    }

}

echo json_encode(
    $sucesso
        ? ['sucesso' => true]
        : ['erro' => 'Falha ao salvar']
);

?>
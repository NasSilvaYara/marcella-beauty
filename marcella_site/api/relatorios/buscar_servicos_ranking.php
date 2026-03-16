<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "marcella_beauty");

if ($conn->connect_error) {
    echo json_encode(["erro" => "Erro conexão"]);
    exit;
}

$mes = $_GET['mes'];
$ano = $_GET['ano'];

/* LISTA COMPLETA DE SERVIÇOS */
$servicosLista = [
    "Manicure",
    "Pedicure",
    "Alongamento",
    "Banho de gel",
    "Esmaltação perm.",
    "Spa dos pés",
    "M. Relaxante",
    "M. Terapêutica",
    "Drenagem",
    "Bandagem",
    "Pós Parto",
    "Buço",
    "Sobrancelha",
    "Rosto",
    "Axilas",
    "Meia Perna",
    "Perna Int.",
    "Virilha Simp.",
    "Virilha Comp.",
    "Extensão Cílios",
    "Design Sobr.",
    "Preenchimento",
    "Botox",
    "Vasinhos",
    "Enzimas"
];

/* iniciar todos com 0 */
$contagem = [];

foreach ($servicosLista as $s) {
    $contagem[$s] = 0;
}

/* buscar agenda */
$sql = "SELECT servicos
FROM agenda
WHERE MONTH(data)=?
AND YEAR(data)=?
AND status='confirmado'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mes, $ano);
$stmt->execute();

$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {

    $listaServicos = explode(",", $row["servicos"]);

    foreach ($listaServicos as $servico) {

        $servico = trim($servico);

        if (isset($contagem[$servico])) {
            $contagem[$servico]++;
        }

    }

}

/* ordenar */
arsort($contagem);

/* top 5 */
$top5 = array_slice($contagem, 0, 5, true);

$outros = array_slice($contagem, 5);
$totalOutros = array_sum($outros);

$dados = [];

foreach ($top5 as $servico => $total) {

    $dados[] = [
        "servico" => $servico,
        "total" => $total
    ];

}

if ($totalOutros > 0) {

    $dados[] = [
        "servico" => "Outros",
        "total" => $totalOutros
    ];

}

echo json_encode($dados);
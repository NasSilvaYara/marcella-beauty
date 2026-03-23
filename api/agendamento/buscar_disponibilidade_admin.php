/*
===========================================================
ARQUIVO: buscar_disponibilidade_admin.php

FUNÇÃO:
Retornar a configuração de disponibilidade criada pelo admin.

COMO FUNCIONA:
- Busca registros da tabela "disponibilidade"
- Retorna dias configurados como:
    - trabalho
    - folga

RETORNO:
Lista de objetos com:
- tipo (trabalho/folga)
- dia
- horário início/fim

USO:
- Alimenta o calendário do painel admin
- Permite visualizar dias abertos/fechados

OBS:
Não calcula horários disponíveis.
Apenas mostra regras cadastradas.
===========================================================
*/

<?php

header('Content-Type: application/json');

$conn = new mysqli("localhost","root","","marcella_beauty");

if($conn->connect_error){
    echo json_encode([]);
    exit;
}

$mes = intval($_GET['mes'] ?? date("n"));
$ano = intval($_GET['ano'] ?? date("Y"));

$sql = "SELECT * FROM disponibilidade WHERE mes=? AND ano=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$mes,$ano);
$stmt->execute();
$res = $stmt->get_result();

$regras = [];

while($row = $res->fetch_assoc()){
    $regras[] = $row;
}

$diasMes = cal_days_in_month(CAL_GREGORIAN,$mes,$ano);

$resultado = [];

for($dia=1;$dia<=$diasMes;$dia++){

    $data = $ano."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-".str_pad($dia,2,"0",STR_PAD_LEFT);

    $numeroSemana = date("N",strtotime($data));

    $mapa = [
        1=>"segunda",
        2=>"terca",
        3=>"quarta",
        4=>"quinta",
        5=>"sexta",
        6=>"sabado",
        7=>"domingo"
    ];

    $diaSemana = $mapa[$numeroSemana];

    foreach($regras as $regra){

        if($regra['dia_semana'] == $diaSemana){

            $resultado[] = [
                "tipo"=>$regra['tipo'],
                "dia"=>$data,
                "inicio"=>$regra['hora_inicio'],
                "fim"=>$regra['hora_fim']
            ];

        }

    }

}

echo json_encode($resultado);
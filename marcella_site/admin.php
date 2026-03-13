<?php
session_start();

// 1. Configuração de Segurança
$emailAdmin = "goncalvesmarcella@gmail.com"; // Verifique se é 'goncalves' ou 'golcalves'

if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== $emailAdmin) {
    header("Location: index.php"); // Expulsa quem não é admin
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo | Marcella Gonçalves</title>
    <link rel="stylesheet" href="style.css"> 
    <style>
        /* Estilo específico para a área administrativa */
        .admin-container {
            padding: 50px 10%;
            min-height: 80vh;
            background-color: #fff; /* Ou a cor de fundo que você usa */
        }
        .painel-box {
            background: #fdfafd; 
            border: 2px solid #a066ff; 
            padding: 40px; 
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(160, 102, 255, 0.1);
        }
    </style>
</head>
<body>

    <main class="admin-container">
        <div class="painel-box">
            <h1 style="color: #a066ff; font-family: 'Playfair Display', serif;">Painel de Gestão</h1>
            <p>Olá, Marcella! Aqui você pode gerenciar seus horários e agendamentos.</p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

            <div id="gerenciador-horarios">
                </div>
        </div>
    </main>

    </body>
</html>
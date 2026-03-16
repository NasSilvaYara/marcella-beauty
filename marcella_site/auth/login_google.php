<?php
session_start();

// Recebe os dados do fetch
$data = json_decode(file_get_contents("php://input"), true);
$id_token = $data['id_token'];

if ($id_token) {
    // 1. Em produção, você deve validar o token usando a API do Google:
    // https://oauth2.googleapis.com/tokeninfo?id_token=TOKEN
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
    $response = file_get_contents($url);
    $user = json_decode($response, true);

    if (isset($user['email'])) {
        // O Google confirmou quem é o usuário!
        // 2. Aqui você verifica se o e-mail já existe no seu banco de dados
        // Se não existir, você cadastra. Se existir, você loga.
        
        $_SESSION['usuario_id'] = $user['sub']; // ID único do Google
        $_SESSION['usuario_nome'] = $user['name'];
        $_SESSION['usuario_email'] = $user['email'];

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Token inválido']);
    }
}
?>
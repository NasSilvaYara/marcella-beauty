<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);
$id_token = $data['id_token'];

if ($id_token) {
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
    $response = file_get_contents($url);
    $user = json_decode($response, true);

    if (isset($user['email'])) {

        $_SESSION['usuario_id'] = $user['sub']; 
        $_SESSION['usuario_nome'] = $user['name'];
        $_SESSION['usuario_email'] = $user['email'];

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Token inválido']);
    }
}
?>
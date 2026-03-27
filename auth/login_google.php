<?php
session_start();
header('Content-Type: application/json');

// pega JSON corretamente
$data = json_decode(file_get_contents("php://input"), true);
$id_token = $data['credential'] ?? null;

if (!$id_token) {
    echo json_encode(['success' => false, 'message' => 'Token não enviado']);
    exit;
}

$url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
    echo json_encode(['success' => false, 'message' => 'Erro ao validar token']);
    exit;
}

$user = json_decode($response, true);

$CLIENT_ID = "821436734385-7cdnrc9a23v52qkfekevi35sumdr4so8.apps.googleusercontent.com";

if (
    isset($user['email']) &&
    isset($user['aud']) &&
    $user['aud'] === $CLIENT_ID
) {
    $_SESSION['usuario_id'] = $user['sub'];
    $_SESSION['usuario_nome'] = $user['name'] ?? 'Usuário';
    $_SESSION['usuario_email'] = $user['email'];

    echo json_encode(['success' => true]);

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Token inválido ou client_id incorreto',
        'debug' => $user
    ]);
}
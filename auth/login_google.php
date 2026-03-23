/*
===========================================================
ARQUIVO: auth/login_google.php

PROPÓSITO:
Autenticar usuário usando Google Sign‑In com token.

FUNCIONALIDADE:
- Recebe JSON com id_token da Google API.
- Faz fetch em endpoint do Google para validar token.
- Se token válido, recupera o email + nome do usuário.
- Guarda dados do usuário na sessão:
  $_SESSION['usuario_id'], $_SESSION['usuario_nome'],
  $_SESSION['usuario_email'].
- Retorna JSON { success: true } para o front.
- Em caso de falha, retorna success:false com mensagem.
===========================================================
*/

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
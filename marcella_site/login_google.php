<?php
session_start();
require_once 'db_config.php'; // Garante que a conexão com o banco está ativa

// Recebe o JSON enviado pelo fetch no index.php
$data = json_decode(file_get_contents("php://input"), true);
$id_token = isset($data['id_token']) ? $data['id_token'] : null;

if ($id_token) {
    // 1. Validação do token com a API do Google (Server-side)
    $url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
    $response = @file_get_contents($url);
    $user = json_decode($response, true);

    if (isset($user['email'])) {
        $email = $user['email'];
        $nome = $user['name'];
        // O 'sub' é o ID único e imutável do usuário no Google
        $google_id = $user['sub']; 

        // 2. Verifica se o usuário já existe no seu banco de dados
        $sql = "SELECT id, nome FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($usuario_existente = $resultado->fetch_assoc()) {
            // Usuário já cadastrado: Inicia a sessão com os dados do banco
            $_SESSION['user_id'] = $usuario_existente['id'];
            $_SESSION['user_nome'] = $usuario_existente['nome'];
            echo json_encode(['success' => true]);
        } else {
            // Usuário novo: Vamos cadastrar automaticamente
            // Geramos uma senha aleatória segura (ele não precisará dela para logar via Google)
            $senha_aleatoria = password_hash(uniqid(), PASSWORD_DEFAULT);
            
            $insere = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
            $stmt_insere = $conn->prepare($insere);
            $stmt_insere->bind_param("sss", $nome, $email, $senha_aleatoria);
            
            if ($stmt_insere->execute()) {
                // Cadastro feito com sucesso: Loga o usuário
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_nome'] = $nome;
                echo json_encode(['success' => true]);
            } else {
                // Erro técnico ao inserir no banco
                echo json_encode(['success' => false, 'message' => 'Erro ao criar conta no banco de dados.']);
            }
        }
    } else {
        // Token rejeitado pelo Google
        echo json_encode(['success' => false, 'message' => 'Autenticação do Google inválida.']);
    }
} else {
    // Caso o script seja acessado sem o token
    echo json_encode(['success' => false, 'message' => 'Token não fornecido.']);
}
?>
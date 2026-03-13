<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Coleta os dados (Limpando espaços extras)
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha_digitada = isset($_POST['senha']) ? $_POST['senha'] : '';

    // 2. Validação simples
    if (empty($email) || empty($senha_digitada)) {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // 3. Busca o usuário
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($user = $resultado->fetch_assoc()) {
            
            // 4. Verifica a senha
            if (password_verify($senha_digitada, $user['senha'])) {
                
                // --- SUCESSO: SALVA NA SESSÃO ---
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_nome']  = $user['nome'];
                $_SESSION['user_email'] = $email; // ESSENCIAL PARA O ADMIN

                header("Location: index.php");
                exit;
            } else {
                // Senha errada
                header("Location: index.php?erro=1");
                exit;
            }
        } else {
            // E-mail não existe
            header("Location: index.php?erro=1");
            exit;
        }
    }
} else {
    header("Location: index.php");
    exit;
}
?>
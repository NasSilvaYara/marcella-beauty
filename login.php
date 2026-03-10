<?php
/**
 * login.php
 * Script para verificar as credenciais do utilizador e iniciar uma sessão.
 */

// 1. Inicia a sessão do PHP (deve ser a primeira coisa no ficheiro)
session_start();

// 2. Inclui a ligação à base de dados
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha_digitada = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($email) || empty($senha_digitada)) {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // 3. Procura o utilizador pelo e-mail
    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // 4. Verifica se encontrou o utilizador
        if ($user = $resultado->fetch_assoc()) {
            
            // 5. Verifica se a palavra-passe coincide com o Hash guardado
            if (password_verify($senha_digitada, $user['senha'])) {
                
                // Login com sucesso! Guarda os dados na sessão
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nome'] = $user['nome'];

                echo "<script>
                        alert('Bem-vinda de volta, " . $user['nome'] . "!');
                        window.location.href = 'painel.php'; 
                      </script>";
            } else {
                echo "<script>alert('Palavra-passe incorreta.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('E-mail não encontrado.'); window.history.back();</script>";
        }
        $stmt->close();
    }
}
$conn->close();
?>
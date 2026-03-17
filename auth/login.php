<?php

session_start();

require_once 'config/db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha_digitada = isset($_POST['senha']) ? $_POST['senha'] : '';

    if (empty($email) || empty($senha_digitada)) {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($user = $resultado->fetch_assoc()) {
            
            if (password_verify($senha_digitada, $user['senha'])) {
                
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];

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

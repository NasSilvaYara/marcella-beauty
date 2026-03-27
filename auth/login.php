/*
===========================================================
ARQUIVO: login.php

PROPÓSITO:
Autenticar usuário por e‑mail e senha.

FUNCIONALIDADE:
- Recebe POST com email e senha.
- Faz SELECT na tabela "usuarios" para encontrar o
usuário correspondente.
- Se encontrado, verifica a senha usando
password_verify().
- Se válido, inicia sessão com:
$_SESSION['usuario_id'], $_SESSION['usuario_nome'],
$_SESSION['usuario_email'].
- Redireciona para a página principal após login.

SEGURANÇA:
Usa hashing com password_verify, sessão para manter
usuário autenticado.
===========================================================
*/
<?php

session_start();

require_once '../config/db_config.php';

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
                $_SESSION['usuario_email'] = $email;

                header("Location: ../index.php"); // ajuste se necessário
                exit;

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
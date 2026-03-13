<?php
/**
 * registro.php
 * Este é o ÚNICO arquivo necessário para criar novas contas (Cadastro/Registro).
 */

// 1. Iniciar a sessão para logar o usuário automaticamente após o registro
session_start();

// 2. Incluir a configuração do banco de dados
// Certifique-se de que o arquivo db_config.php existe na mesma pasta
require_once 'db_config.php';

// 3. Processar apenas se o formulário for enviado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capturar dados do formulário e remover espaços extras
    // Certifique-se de que no index.php os campos tenham estes 'name'
    $nome  = isset($_POST['nome_completo']) ? trim($_POST['nome_completo']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

    // Verificação básica de segurança
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos corretamente.'); window.history.back();</script>";
        exit;
    }

    // 4. Verificar se o e-mail já está em uso (para não duplicar contas)
    $checkEmail = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $resultado = $checkEmail->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Este e-mail já está cadastrado. Tente fazer login.'); window.history.back();</script>";
        exit;
    }
    $checkEmail->close();

    // 5. Criptografar a senha por segurança
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // 6. Inserir o novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sss", $nome, $email, $senhaHash);
        
        if ($stmt->execute()) {
            // 7. SUCESSO! Guardar dados na sessão para o usuário já aparecer como "Logado"
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['user_nome'] = $nome;

            // Redirecionar para a página principal
            header("Location: index.php");
            exit;
        } else {
            echo "Erro ao salvar os dados: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro na preparação do banco de dados.";
    }
} else {
    // Se alguém tentar acessar este arquivo diretamente pela URL, volta para a home
    header("Location: index.php");
    exit;
}

$conn->close();
?>
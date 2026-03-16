<?php
// 1. Iniciar a sessão para o utilizador ficar logado logo após o registo
session_start();

// 2. Incluir o ficheiro de ligação ao banco de dados que criamos (config.php)
// Certifica-te de que o teu ficheiro de conexão se chama config.php
include('config/db_config.php');

// 3. Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Pegar nos dados do formulário de forma segura
    // Os nomes dentro de $_POST['...'] devem ser os mesmos do atributo 'name' no HTML
    $nome  = mysqli_real_escape_string($conn, $_POST['nome_completo']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];

    // 4. Encriptar a senha (Segurança: Nunca guardes senhas em texto limpo!)
    $senha_encriptada = password_hash($senha, PASSWORD_DEFAULT);

    // 5. Comando SQL para inserir no banco de dados
    // A tabela 'usuarios' deve existir no seu MySQL (conforme o guia anterior)
    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_encriptada')";

    if ($conn->query($sql) === TRUE) {
        // 6. Sucesso! Agora vamos guardar os dados na Sessão para ele ficar LOGADO
        $ultimo_id = $conn->insert_id; // Pega o ID que acabou de ser criado
        
        $_SESSION['usuario_id'] = $ultimo_id;
        $_SESSION['usuario_nome'] = $nome;

        // 7. Redirecionar para a página principal
        header("Location: index.php");
        exit();
    } else {
        // Se der erro (ex: e-mail já existe)
        echo "Erro ao registar: " . $conn->error;
    }
}

$conn->close();
?>
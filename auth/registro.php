<?php

session_start();

include('config/db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome  = mysqli_real_escape_string($conn, $_POST['nome_completo']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];

    $senha_encriptada = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha_encriptada')";

    if ($conn->query($sql) === TRUE) {
    
        $ultimo_id = $conn->insert_id; 
        
        $_SESSION['usuario_id'] = $ultimo_id;
        $_SESSION['usuario_nome'] = $nome;

        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao registar: " . $conn->error;
    }
}

$conn->close();
?>
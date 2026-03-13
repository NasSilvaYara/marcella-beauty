<?php
/**
 * db_config.php
 * Ficheiro de configuração de ligação à base de dados MySQL.
 * Este ficheiro é responsável por estabelecer a comunicação entre o seu site e o banco de dados.
 */

// Definições de acesso ao servidor local (XAMPP)
$host = "localhost";    // Endereço do servidor
$usuario = "root";     // Utilizador padrão do MySQL no XAMPP
$senha = "";           // Por padrão, a palavra-passe do XAMPP é vazia
$banco = "marcella_beauty"; // Nome da base de dados que criou no phpMyAdmin

// Criar a ligação (instanciar o objeto mysqli)
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verificar se existe algum erro de ligação
if ($conn->connect_error) {
    // Se falhar, o script para aqui e mostra o erro
    die("Falha na ligação: " . $conn->connect_error);
}

// Configurar a codificação de caracteres para UTF-8 para evitar erros de acentuação
$conn->set_charset("utf8mb4");

// Se chegar aqui sem erros, a ligação foi bem-sucedida
?>
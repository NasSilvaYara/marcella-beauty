<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "marcella_beauty";

$conn = new mysqli($host,$user,$pass,$db);

if($conn->connect_error){
    die("Erro conexão: " . $conn->connect_error);
}

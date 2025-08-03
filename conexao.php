<?php
$servername = "localhost";
$username = "root";      // ajuste se necessário
$password = "";          // ajuste se necessário
$dbname = "painel_consultas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>

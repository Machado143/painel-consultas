<?php

$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'painel_consultas';

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if ($conn === conection_error) {
    die("Erro na conexão: " . $conn-> connection_error);
}
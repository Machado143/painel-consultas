<?php
include _once '../conexao.php';

<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>


$id = $_GET['id'] ?? null;

if (!$id) {
    $conn->query("DELETE FROM pacientes WHERE id = $id");
}

header("Location: listar.php"); 
exit();
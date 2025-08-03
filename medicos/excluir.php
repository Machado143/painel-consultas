<?php
include_once '../conexao.php';

<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

?id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM medicos WHERE id = $id";
    $conn-> query($sql);
}

header("Location: listar.php");
exit();
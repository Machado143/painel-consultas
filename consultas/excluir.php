<?php
include _once '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    $conn->query("DELETE FROM pacientes WHERE id = $id");
}

header("Location: listar.php"); 
exit();
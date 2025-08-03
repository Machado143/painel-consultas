<?php
include_once '../conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    $sql = "DELETE FROM pacientes WHERE id = $id";
    $conn->query($sql);
}

header("Location: listar.php");
exit();
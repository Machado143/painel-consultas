<?php
include_once '../conexao.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Corrigido para deletar da tabela 'consultas'
    $stmt = $conn->prepare("DELETE FROM consultas WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: listar.php");
exit();
?>

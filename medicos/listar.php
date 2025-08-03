<?php
include_once '../conexao.php';

$sql = "SELECT * FROM medicos";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Médicos</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Lista de Médicos</h1>
    <a href="cadastrar.php">+ Novo Médico</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CRM</th>
            <th>Especialidade</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        <?php while ($medico = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($medico['id']) ?></td>
                <td><?= htmlspecialchars($medico['nome']) ?></td>
                <td><?= htmlspecialchars($medico['crm']) ?></td>
                <td><?= htmlspecialchars($medico['especialidade']) ?></td>
                <td><?= htmlspecialchars($medico['telefone']) ?></td>
                <td>
                    <a href="editar.php?id=<?= $medico['id'] ?>">Editar</a> |
                    <a href="excluir.php?id=<?= $medico['id'] ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="../index.php">Voltar ao Início</a>
</body>
</html>

<?php
include_once '../conexao.php';

$sql = "SELECT * FROM pacientes";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>

<h1>Lista de Pacientes</h1>
<a href="cadastrar.php">+ Novo Paciente</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Telefone</th>
        <th>Data de Nascimento</th>
        <th>Ações</th>
    </tr>

    <?php while ($paciente = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($paciente['id']) ?></td>
        <td><?= htmlspecialchars($paciente['nome']) ?></td>
        <td><?= htmlspecialchars(preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $paciente['cpf'])) ?></td>
        <td><?= htmlspecialchars(preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $paciente['telefone'])) ?></td>
        <td>
            <?php 
            if (!empty($paciente['data_nascimento']) && $paciente['data_nascimento'] !== '0000-00-00') {
                echo htmlspecialchars(date('d/m/Y', strtotime($paciente['data_nascimento'])));
            } else {
                echo '<span class="text-gray-400">N/D</span>';
            }
            ?>
        </td>
        <td>
            <a href="editar.php?id=<?= htmlspecialchars($paciente['id']); ?>">Editar</a> |
            <a href="excluir.php?id=<?= htmlspecialchars($paciente['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="../index.php">Voltar ao Início</a>

</body>
</html>

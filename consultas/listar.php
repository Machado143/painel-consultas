<?php
include_once '../conexao.php';

$sql = "SELECT consultas.id, pacientes.nome AS paciente, medicos.nome AS medico, data, horario, observacoes
        FROM consultas
        JOIN pacientes ON consultas.paciente_id = pacientes.id
        JOIN medicos ON consultas.medico_id = medicos.id
        ORDER BY data, horario";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Consultas</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>

<h1>Lista de Consultas</h1>
<a href="agendar.php">+ Nova Consulta</a>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Paciente</th>
        <th>Médico</th>
        <th>Data</th>
        <th>Horário</th>
        <th>Observações</th>
        <th>Ações</th>
    </tr>

    <?php while ($consulta = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($consulta['id']) ?></td>
        <td><?= htmlspecialchars($consulta['paciente']) ?></td>
        <td><?= htmlspecialchars($consulta['medico']) ?></td>
        <td><?= htmlspecialchars($consulta['data']) ?></td>
        <td><?= htmlspecialchars($consulta['horario']) ?></td>
        <td><?= htmlspecialchars($consulta['observacoes']) ?></td>
        <td>
            <a href="editar.php?id=<?= $consulta['id'] ?>">Editar</a> |
            <a href="excluir.php?id=<?= $consulta['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

<br>
<a href="../index.php">Voltar ao Início</a>

</body>
</html>

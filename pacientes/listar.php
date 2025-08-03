<?php
include_once '../conexao.php';

$sql = "SELECT * FROM pacientes ORDER BY nome";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Lista de Pacientes</h1>
<a href="cadastrar.php">+ Novo Paciente</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>CPF</th>
        <th>Data de Nascimento</th>
        <th>Gênero</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Ações</th>
    </tr>

    <?php while ($paciente = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($paciente['id']) ?></td>
        <td><?= htmlspecialchars($paciente['nome']) ?></td>
        <td><?= htmlspecialchars(preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $paciente['cpf'])) ?></td>
        <td>
            <?php 
            if (!empty($paciente['data_nascimento']) && $paciente['data_nascimento'] !== '0000-00-00') {
                echo htmlspecialchars(date('d/m/Y', strtotime($paciente['data_nascimento'])));
            } else {
                echo '<span style="color: #999;">N/D</span>';
            }
            ?>
        </td>
        <td>
            <?php 
            $genero_texto = '';
            switch($paciente['genero']) {
                case 'M': $genero_texto = 'Masculino'; break;
                case 'F': $genero_texto = 'Feminino'; break;
                case 'O': $genero_texto = 'Outro'; break;
                default: $genero_texto = 'N/D';
            }
            echo htmlspecialchars($genero_texto);
            ?>
        </td>
        <td><?= htmlspecialchars($paciente['email']) ?></td>
        <td><?= htmlspecialchars(preg_replace('/(\d{2})(\d{4,5})(\d{4})/', '($1) $2-$3', $paciente['telefone'])) ?></td>
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
<?php 
incldue '../conexao.php';

$sql = "SELECT * FROM medicos";
$resultado = $conn->query($sql);
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Médicos</title>
</head>
<body>
    <h1>Lista de Médicos</h1>
    <a href="cadastrar.php">+ Novo Médico</a>
    <table border="1" cellpadding="8">
        <tr> 
            <th>ID</th>
            <th>Nome</th>
            <th>CRM</th>
            <th>Especialidade</th>
            <th>Ações</th>
        </tr>
        <?php while ($medico = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $medico['id']; ?></td>
                <td><?php echo $medico['nome']; ?></td>
                <td><?php echo $medico['crm']; ?></td>
                <td><?php echo $medico['especialidade']; ?></td>

                <td>
                    <a href="editar.php?id=<? $medico['id']; ?>">Editar</a> |
                    <a href="excluir.php?id=<? $medico['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="../index.php">Voltar ao Inicio</a>
</body>
</html>
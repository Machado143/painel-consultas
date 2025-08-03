<?php
include_once '../conexao.php';


//Busca todos os pacientes
$sql = "SELECT * FROM pacientes";
$resultado = $conn->query($sql);
?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Pacientes</title>
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>
    <body>
        <h1>Lista de Pacientes</h1>
        <a href="cadastrar.php">+ Novo Paciente</a>
        <table border="1" cellpadding="8">
            <tr> 
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>Nascimento</th>
                <th>Ações</th>
            </tr>
            <?php while ($paciente = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $paciente['id']; ?></td>
                    <td><?php echo $paciente['nome']; ?></td>
                    <td><?php echo $paciente['cpf']; ?></td>
                    <td><?php echo $paciente['telefone']; ?></td>
                    <td><?php echo $paciente['nascimento']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $paciente['id']; ?>">Editar</a> |
                        <a href="excluir.php?id=<?php echo $paciente['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <br>
        <a href="../index.php">Voltar ao Inicio</a>
    </body>
</html>
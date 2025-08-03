<?php
include_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $crm = $_POST['crm'];
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];

    $stmt = $conn->prepare("INSERT INTO medicos (nome, crm, especialidade, telefone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $crm, $especialidade, $telefone);

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Médico</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Cadastrar Médico</h1>
    <form method="post">
        Nome: <input type="text" name="nome" required><br><br>
        CRM: <input type="text" name="crm" required><br><br>
        Especialidade: <input type="text" name="especialidade" required><br><br>
        Telefone: <input type="text" name="telefone" required><br><br>
        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>

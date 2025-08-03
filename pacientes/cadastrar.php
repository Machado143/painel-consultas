<?php
include_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    // Insere o paciente no banco de dados usando prepared statements
    $stmt = $conn->prepare("INSERT INTO pacientes (nome, cpf, telefone, data_nascimento) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $cpf, $telefone, $data_nascimento);
    
    if ($stmt->execute()) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Paciente</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Cadastrar Paciente</h1>
    <form method="post">
        Nome: <input type="text" name="nome" required><br><br>
        CPF: <input type="text" name="cpf" required><br><br>
        Telefone: <input type="text" name="telefone" required><br><br>
        Data de Nascimento: <input type="date" name="data_nascimento" required><br><br>
        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>

<?php
include_once '../conexao.php';
?>

<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>


if ($_SERVER ["REQUEST_MESTHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    // Insere o paciente no banco de dados
    $sql = "INSERT INTO pacientes (nome, cpf, telefone, nascimento) 
    VALUES ('$nome', '$cpf', '$telefone', '$nascimento')";
    
    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<h1>Cadastrar Paciente</h1>
<form method="post">
    Nome: <input type="text" name="nome" required><br><br>
    CPF: <input type="text" name="cpf" required><br><br>
    Telefone: <input type="text" name="telefone" required><br><br>
    Data de Nascimento: <input type="date" name="nascimento" required><br><br>
    <button type="submit">Salvar</button>
</form>
<br>
<a href="listar.php">Voltar</a>
<?php 

include_once '../conexao.php';

<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $crm = $_POST['crm'];
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];

    // Insere o médico no banco de dados
    $sql = "INSERT INTO medicos (nome, crm, especialidade, telefone) 
    VALUES ('$nome', '$crm', '$especialidade', '$telefone')";
    
    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<h1>Cadastrar médico</h1>
<form method="POST" action="">
    Nome: <input type="text" name="nome" required><br><br>
    CRM: <input type="text" name="crm" required><br><br>
    Especialidade: <input type="text" name="especialidade" required><br><br>
    <button type="submit">Salvar</button>
</form>
<br>
<a href="listar.php">Voltar</a>
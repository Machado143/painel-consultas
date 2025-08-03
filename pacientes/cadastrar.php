<?php
include_once '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Insere o paciente no banco de dados usando prepared statements
    $stmt = $conn->prepare("INSERT INTO pacientes (nome, cpf, data_nascimento, genero, email, telefone) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome, $cpf, $data_nascimento, $genero, $email, $telefone);
    
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
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Cadastrar Paciente</h1>
    <form method="post">
        Nome: <input type="text" name="nome" required><br><br>
        
        CPF: <input type="text" name="cpf" placeholder="12345678901" maxlength="11" required><br><br>
        
        Data de Nascimento: <input type="date" name="data_nascimento" required><br><br>
        
        Gênero:
        <select name="genero" required>
            <option value="">Selecione</option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outro</option>
        </select><br><br>
        
        Email: <input type="email" name="email" required><br><br>
        
        Telefone: <input type="text" name="telefone" placeholder="11987654321" required><br><br>
        
        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>
<?php
include_once '../conexao.php';

// Habilitar relatórios de erro
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID inválido.";
    exit;
}

// Buscar dados do paciente
$stmt_select = $conn->prepare("SELECT * FROM pacientes WHERE id = ?");
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$resultado = $stmt_select->get_result();
$paciente = $resultado->fetch_assoc();
$stmt_select->close();

if (!$paciente) {
    echo "Paciente não encontrado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Atualiza os dados do paciente no banco de dados usando prepared statements
    $stmt_update = $conn->prepare("UPDATE pacientes SET nome=?, cpf=?, data_nascimento=?, genero=?, email=?, telefone=? WHERE id=?");
    $stmt_update->bind_param("ssssssi", $nome, $cpf, $data_nascimento, $genero, $email, $telefone, $id);

    if ($stmt_update->execute()) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt_update->error;
    }
    $stmt_update->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Editar Paciente</h1>
    <form method="post">
        Nome: <input type="text" name="nome" value="<?= htmlspecialchars($paciente['nome']); ?>" required><br><br>
        
        CPF: <input type="text" name="cpf" value="<?= htmlspecialchars($paciente['cpf']); ?>" required><br><br>
        
        Data de Nascimento: <input type="date" name="data_nascimento" value="<?= htmlspecialchars($paciente['data_nascimento']); ?>" required><br><br>
        
        Gênero:
        <select name="genero" required>
            <option value="M" <?= $paciente['genero'] == 'M' ? 'selected' : '' ?>>Masculino</option>
            <option value="F" <?= $paciente['genero'] == 'F' ? 'selected' : '' ?>>Feminino</option>
            <option value="O" <?= $paciente['genero'] == 'O' ? 'selected' : '' ?>>Outro</option>
        </select><br><br>
        
        Email: <input type="email" name="email" value="<?= htmlspecialchars($paciente['email']); ?>" required><br><br>
        
        Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($paciente['telefone']); ?>" required><br><br>
        
        <button type="submit">Salvar Mudanças</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>
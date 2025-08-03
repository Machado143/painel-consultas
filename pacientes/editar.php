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
    $telefone = $_POST['telefone'];
    $data_nascimento = $_POST['data_nascimento'];

    // Atualiza os dados do paciente no banco de dados usando prepared statements
    $stmt_update = $conn->prepare("UPDATE pacientes SET nome=?, cpf=?, telefone=?, data_nascimento=? WHERE id=?");
    $stmt_update->bind_param("ssssi", $nome, $cpf, $telefone, $data_nascimento, $id);

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
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Editar Paciente</h1>
    <form method="post">
        Nome: <input type="text" name="nome" value="<?= htmlspecialchars($paciente['nome']); ?>" required><br><br>
        CPF: <input type="text" name="cpf" value="<?= htmlspecialchars($paciente['cpf']); ?>" required><br><br>
        Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($paciente['telefone']); ?>" required><br><br>
        Data de Nascimento: <input type="date" name="data_nascimento" value="<?= htmlspecialchars($paciente['data_nascimento']); ?>" required><br><br>
        <button type="submit">Salvar Mudanças</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>

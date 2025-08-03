<?php
include_once '../conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID inválido.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM medicos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$medico = $resultado->fetch_assoc();
$stmt->close();

if (!$medico) {
    echo "Médico não encontrado.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $crm = $_POST['crm'];
    $especialidade = $_POST['especialidade'];
    $telefone = $_POST['telefone'];

    $stmt = $conn->prepare("UPDATE medicos SET nome=?, crm=?, especialidade=?, telefone=? WHERE id=?");
    $stmt->bind_param("ssssi", $nome, $crm, $especialidade, $telefone, $id);

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
    <title>Editar Médico</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Editar Médico</h1>
    <form method="post">
        Nome: <input type="text" name="nome" value="<?= htmlspecialchars($medico['nome']) ?>" required><br><br>
        CRM: <input type="text" name="crm" value="<?= htmlspecialchars($medico['crm']) ?>" required><br><br>
        Especialidade: <input type="text" name="especialidade" value="<?= htmlspecialchars($medico['especialidade']) ?>" required><br><br>
        Telefone: <input type="text" name="telefone" value="<?= htmlspecialchars($medico['telefone']) ?>" required><br><br>
        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>

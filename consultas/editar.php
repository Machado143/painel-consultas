<?php
include_once '../conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID inválido.";
    exit;
}

$consulta_result = $conn->query("SELECT * FROM consultas WHERE id = $id");
if ($consulta_result->num_rows === 0) {
    echo "Consulta não encontrada.";
    exit;
}
$consulta = $consulta_result->fetch_assoc();

$pacientes = $conn->query("SELECT id, nome FROM pacientes");
$medicos = $conn->query("SELECT id, nome FROM medicos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $observacoes = $_POST['observacoes'];

    $stmt = $conn->prepare("UPDATE consultas SET paciente_id=?, medico_id=?, data=?, horario=?, observacoes=? WHERE id=?");
    $stmt->bind_param("iisssi", $paciente_id, $medico_id, $data, $horario, $observacoes, $id);

    if ($stmt->execute()) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Consulta</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Link para o CSS externo -->
</head>
<body>
    <h1>Editar Consulta</h1>
    <form action="" method="post">
        Paciente:
        <select name="paciente_id" required>
            <?php while ($p = $pacientes->fetch_assoc()): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $consulta['paciente_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nome']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        Médico:
        <select name="medico_id" required>
            <?php while ($m = $medicos->fetch_assoc()): ?>
                <option value="<?= $m['id'] ?>" <?= $m['id'] == $consulta['medico_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['nome']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        Data: <input type="date" name="data" value="<?= $consulta['data'] ?>" required><br><br>
        Horário: <input type="time" name="horario" value="<?= $consulta['horario'] ?>" required><br><br>
        Observações: <br>
        <textarea name="observacoes" rows="4" cols="40"><?= htmlspecialchars($consulta['observacoes']) ?></textarea><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
    <br>
    <a href="listar.php">Voltar</a>
</body>
</html>

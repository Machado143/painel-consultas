<?php

include_once '../conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID inválido.";
    exit;
}
$consulta = $conn->query("SELECT * FROM consultas WHERE id = $id");->fetch_assoc();
$paciente = $conn->query("SELECT id, nome FROM pacientes")
$medicos = $conn->query("SELECT id, nome FROM medicos");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $data = $_POST['data'];
    $horario = $_POST['horaario']
    $observacoes = $_POST['observacoes'];

    // Atualiza a consulta no banco de dados
    $sql = "UPDATE consultas 
    SET paciente_id='$paciente_id', medico_id='$medico_id', data='$data', hora='$hora' 
    WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>
<h1>Editar Consulta</h1>
<form action="" method="post">
    Paciente:
    <select name="paciente_id" required>
        <?php while ($p = $pacientes->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>" <?= $p['id'] == $consulta['paciente_id'] ? 'selected' : '' ?>>
                <?= $p['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    Médico:
    <select name="medico_id" required>
        <?php while ($m = $medicos->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>" <?= $m['id'] == $consulta['medico_id'] ? 'selected' : '' ?>>
                <?= $m['nome'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    Data: <input type="date" name="data" value="<?= $consulta['data'] ?>" required><br><br>
    Horário: <input type="time" name="horario" value="<?= $consulta['horario'] ?>" required><br><br>
    Observações: <br>
    <textarea name="observacoes" rows="4" cols="40"><?= $consulta['observacoes'] ?></textarea><br><br>

    button type="submit">Salvar Alterações</button>
</form>
<br>
<a href="listar.php">Voltar</a>
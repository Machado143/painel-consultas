<?php
include_once '../conexao.php';

$pacientes = $conn->query("SELECT id, nome FROM 'pacientes');

$medicos = $conn->query("SELECT id, nome FROM medicos");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];
    $observacoes = $_POST['observacoes'];

    
    $sql = "INSERT INTO consultas (paciente_id, medico_id, data, horario, observacoes) 
            VALUES ('$paciente_id', '$medico_id', '$data', '$horario', '$observacoes')";
    
    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

h1 >Agendar Consulta</h1>
<form method="post">
    Paciente:
    <select name="paciente_id" required>
        <option value="">Selecione um paciente</option>
        <?php while ($p = $pacientes->fetch_assoc()): ?>
            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    Médico:
    <select name="medico_id" required>
        <option value="">Selecione um médico</option>
        <?php while ($m = $medicos->fetch_assoc()): ?>
            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
        <?php endwhile; ?>
    </select><br><br>
    Data: <input type="date" name="data" required><br><br>
    Horário: <input type="time" name="horario" required><br><br>
    Observaçôes: <br>
    <textarea name="observacoes" rows="4" cols="40"></textarea><br><br>
    <button type="submit">Agendar</button>
</form>
<br>
<a href="listar.php">Voltar</a>
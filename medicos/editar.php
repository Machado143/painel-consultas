<?php
include '../conexao.php';

$id = $_GET['id']; ?? null;
if (!$id) {
    echo "ID inválido.";
    exit();
}

$sql = "SELECT * FROM medicos WHERE id = $id";
$resultado = $conn->query($sql);
$medico = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $crm = $_POST['crm'];
    $especialidade = $_POST['especialidade'];

    // Atualiza o médico no banco de dados
    $sql = "UPDATE medicos SET nome='$nome', crm='$crm', especialidade='$especialidade', telefone='$telefone'
    WHERE id=$id";
    
    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit();
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>
<h1>Editar médico</h1>
<form method="post">
    Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($medico['nome']); ?>" required><br><br>
    CRM: <input type="text" name="crm" value="<?php echo htmlspecialchars($medico['crm']); ?>" required><br><br>
    Especialidade: <input type="text" name="especialidade" value="<?php echo htmlspecialchars($medico['especialidade']); ?>" required><br><br>
    <button type="submit">Salvar Alterações</button>
</form>
<br>
<a href="listar.php">Voltar</a>

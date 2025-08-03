<?php
include_once '../conexao.php';
?>

<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>


$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID invalido.";
    exit;
}

// Buscar dados do paciente
$sql = "SELECT * FROM pacientes WHERE id = $id";
$resultado  = $conn->query($sql);
$paciente = $resultado->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    // Atualiza os dados do paciente no banco de dados
    $sql = "UPDATE pacientes 
    SET nome='$nome', cpf='$cpf', telefone='$telefone', nascimento='$nascimento' 
    WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: listar.php");
        exit;
    } else {
        echo "Erro ao atualizar: " . $conn->error;
    }
}
?>
<h1>Editar Paciente</h1>
<form method="post">
    Nome: <input type="text " name="nome" value="<?=  $paciente['nome']; ?>" required><br><br>
    CPF: <input type="text" name="cpf" value="<?=  $paciente['cpf']; ?>" required><br><br>
    Telefone: <input type="text" name="telefone" value="<?=  $paciente['telefone']; ?>" required><br><br>
    Data de Nascimento: <input type="date" name="nascimento" value="<?=  $paciente['nascimento']; ?>" required><br><br>
    <button type="submit">Salvar Mudanças</button>

</form>
<br>
<a href="listar.php">Voltar</a>
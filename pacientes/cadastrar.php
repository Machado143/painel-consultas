<?php
include_once '../conexao.php';

$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']); // Remove formatação
    $email = trim($_POST['email']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']); // Remove formatação
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];

    // Validações
    if (empty($nome) || empty($cpf) || empty($email) || empty($telefone) || empty($data_nascimento) || empty($genero)) {
        $mensagem = 'Todos os campos são obrigatórios!';
        $tipo_mensagem = 'error';
    } elseif (strlen($cpf) != 11) {
        $mensagem = 'CPF deve ter 11 dígitos!';
        $tipo_mensagem = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = 'Email inválido!';
        $tipo_mensagem = 'error';
    } else {
        // Verificar se CPF já existe
        $stmt_check = $conn->prepare("SELECT id FROM pacientes WHERE cpf = ?");
        $stmt_check->bind_param("s", $cpf);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $mensagem = 'CPF já cadastrado no sistema!';
            $tipo_mensagem = 'error';
            $stmt_check->close();
        } else {
            $stmt_check->close();
            
            // Verificar se email já existe
            $stmt_email = $conn->prepare("SELECT id FROM pacientes WHERE email = ?");
            $stmt_email->bind_param("s", $email);
            $stmt_email->execute();
            $result_email = $stmt_email->get_result();
            
            if ($result_email->num_rows > 0) {
                $mensagem = 'Email já cadastrado no sistema!';
                $tipo_mensagem = 'error';
                $stmt_email->close();
            } else {
                $stmt_email->close();
                
                // Inserir paciente
                $stmt = $conn->prepare("INSERT INTO pacientes (nome, cpf, data_nascimento, genero, email, telefone) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $nome, $cpf, $data_nascimento, $genero, $email, $telefone);
                
                if ($stmt->execute()) {
                    $mensagem = 'Paciente cadastrado com sucesso!';
                    $tipo_mensagem = 'success';
                    // Limpar campos após sucesso
                    $_POST = array();
                } else {
                    $mensagem = 'Erro ao cadastrar paciente: ' . $stmt->error;
                    $tipo_mensagem = 'error';
                }
                $stmt->close();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Paciente - Sistema Médico</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-plus"></i> Cadastrar Paciente</h1>
        
        <div class="nav-links">
            <a href="listar.php"><i class="fas fa-list"></i> Lista de Pacientes</a>
            <a href="../index.php"><i class="fas fa-home"></i> Início</a>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= $tipo_mensagem ?>">
                <i class="fas fa-<?= $tipo_mensagem == 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post" id="formPaciente">
                <div class="form-group">
                    <label for="nome"><i class="fas fa-user"></i> Nome Completo:</label>
                    <input type="text" 
                           id="nome" 
                           name="nome" 
                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" 
                           required 
                           maxlength="100"
                           placeholder="Digite o nome completo">
                </div>

                <div class="form-group">
                    <label for="cpf"><i class="fas fa-id-card"></i> CPF:</label>
                    <input type="text" 
                           id="cpf" 
                           name="cpf" 
                           value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>" 
                           required 
                           maxlength="14"
                           pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
                           placeholder="000.000.000-00">
                </div>

                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                           required 
                           maxlength="100"
                           placeholder="exemplo@email.com">
                </div>

                <div class="form-group">
                    <label for="telefone"><i class="fas fa-phone"></i> Telefone:</label>
                    <input type="text" 
                           id="telefone" 
                           name="telefone" 
                           value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" 
                           required 
                           maxlength="15"
                           pattern="\(\d{2}\) \d{4,5}-\d{4}"
                           placeholder="(00) 00000-0000">
                </div>

                <div class="form-group">
                    <label for="data_nascimento"><i class="fas fa-calendar"></i> Data de Nascimento:</label>
                    <input type="date" 
                           id="data_nascimento" 
                           name="data_nascimento" 
                           value="<?= htmlspecialchars($_POST['data_nascimento'] ?? '') ?>" 
                           required 
                           max="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label for="genero"><i class="fas fa-venus-mars"></i> Gênero:</label>
                    <select id="genero" name="genero" required>
                        <option value="">Selecione o gênero</option>
                        <option value="M" <?= (($_POST['genero'] ?? '') == 'M') ? 'selected' : '' ?>>Masculino</option>
                        <option value="F" <?= (($_POST['genero'] ?? '') == 'F') ? 'selected' : '' ?>>Feminino</option>
                        <option value="O" <?= (($_POST['genero'] ?? '') == 'O') ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Cadastrar Paciente
                </button>
            </form>
        </div>
    </div>

    <script>
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });

        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });

        // Validação de idade (mínima de 0 anos, máxima de 120 anos)
        document.getElementById('data_nascimento').addEventListener('change', function(e) {
            const hoje = new Date();
            const nascimento = new Date(e.target.value);
            const idade = hoje.getFullYear() - nascimento.getFullYear();
            
            if (idade > 120) {
                alert('Data de nascimento inválida. Idade não pode ser superior a 120 anos.');
                e.target.value = '';
            }
        });

        // Validação do formulário antes do envio
        document.getElementById('formPaciente').addEventListener('submit', function(e) {
            const cpf = document.getElementById('cpf').value.replace(/\D/g, '');
            const telefone = document.getElementById('telefone').value.replace(/\D/g, '');
            
            if (cpf.length !== 11) {
                alert('CPF deve ter 11 dígitos!');
                e.preventDefault();
                return false;
            }
            
            if (telefone.length < 10 || telefone.length > 11) {
                alert('Telefone deve ter 10 ou 11 dígitos!');
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>
</html>
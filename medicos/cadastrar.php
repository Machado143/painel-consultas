<?php
include_once '../conexao.php';

$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $crm = trim($_POST['crm']);
    $especialidade = trim($_POST['especialidade']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']); // Remove formatação

    // Validações
    if (empty($nome) || empty($crm) || empty($especialidade) || empty($telefone)) {
        $mensagem = 'Todos os campos são obrigatórios!';
        $tipo_mensagem = 'error';
    } elseif (strlen($telefone) < 10 || strlen($telefone) > 11) {
        $mensagem = 'Telefone deve ter 10 ou 11 dígitos!';
        $tipo_mensagem = 'error';
    } else {
        // Verificar se CRM já existe
        $stmt_check = $conn->prepare("SELECT id FROM medicos WHERE crm = ?");
        $stmt_check->bind_param("s", $crm);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $mensagem = 'CRM já cadastrado no sistema!';
            $tipo_mensagem = 'error';
            $stmt_check->close();
        } else {
            $stmt_check->close();
            
            // Inserir médico
            $stmt = $conn->prepare("INSERT INTO medicos (nome, crm, especialidade, telefone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $crm, $especialidade, $telefone);

            if ($stmt->execute()) {
                $mensagem = 'Médico cadastrado com sucesso!';
                $tipo_mensagem = 'success';
                // Limpar campos após sucesso
                $_POST = array();
            } else {
                $mensagem = 'Erro ao cadastrar médico: ' . $stmt->error;
                $tipo_mensagem = 'error';
            }
            $stmt->close();
        }
    }
}

// Lista de especialidades médicas
$especialidades = [
    'Cardiologia', 'Dermatologia', 'Endocrinologia', 'Gastroenterologia',
    'Ginecologia', 'Neurologia', 'Oftalmologia', 'Ortopedia',
    'Otorrinolaringologia', 'Pediatria', 'Psiquiatria', 'Urologia',
    'Anestesiologia', 'Cirurgia Geral', 'Clínica Geral', 'Oncologia',
    'Pneumologia', 'Radiologia', 'Reumatologia', 'Infectologia'
];
sort($especialidades);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Médico - Sistema Médico</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-md-plus"></i> Cadastrar Médico</h1>
        
        <div class="nav-links">
            <a href="listar.php"><i class="fas fa-list"></i> Lista de Médicos</a>
            <a href="../index.php"><i class="fas fa-home"></i> Início</a>
        </div>

        <?php if (!empty($mensagem)): ?>
            <div class="alert alert-<?= $tipo_mensagem ?>">
                <i class="fas fa-<?= $tipo_mensagem == 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post" id="formMedico">
                <div class="form-group">
                    <label for="nome"><i class="fas fa-user"></i> Nome Completo:</label>
                    <input type="text" 
                           id="nome" 
                           name="nome" 
                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" 
                           required 
                           maxlength="100"
                           placeholder="Digite o nome completo do médico">
                </div>

                <div class="form-group">
                    <label for="crm"><i class="fas fa-id-badge"></i> CRM:</label>
                    <input type="text" 
                           id="crm" 
                           name="crm" 
                           value="<?= htmlspecialchars($_POST['crm'] ?? '') ?>" 
                           required 
                           maxlength="20"
                           placeholder="Ex: CRM123456, CRM/SP 123456">
                </div>

                <div class="form-group">
                    <label for="especialidade"><i class="fas fa-stethoscope"></i> Especialidade:</label>
                    <select id="especialidade" name="especialidade" required>
                        <option value="">Selecione uma especialidade</option>
                        <?php foreach ($especialidades as $esp): ?>
                            <option value="<?= $esp ?>" <?= (($_POST['especialidade'] ?? '') == $esp) ? 'selected' : '' ?>>
                                <?= $esp ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="Outra">Outra (especificar no campo abaixo)</option>
                    </select>
                </div>

                <div class="form-group" id="outra-especialidade" style="display: none;">
                    <label for="especialidade_outra"><i class="fas fa-edit"></i> Especificar Especialidade:</label>
                    <input type="text" 
                           id="especialidade_outra" 
                           name="especialidade_outra" 
                           maxlength="50"
                           placeholder="Digite a especialidade">
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

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Cadastrar Médico
                </button>
            </form>
        </div>
    </div>

    <script>
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

        // Mostrar/ocultar campo de especialidade personalizada
        document.getElementById('especialidade').addEventListener('change', function() {
            const outraEspDiv = document.getElementById('outra-especialidade');
            const outraEspInput = document.getElementById('especialidade_outra');
            
            if (this.value === 'Outra') {
                outraEspDiv.style.display = 'block';
                outraEspInput.required = true;
            } else {
                outraEspDiv.style.display = 'none';
                outraEspInput.required = false;
                outraEspInput.value = '';
            }
        });

        // Validação do formulário
        document.getElementById('formMedico').addEventListener('submit', function(e) {
            const especialidade = document.getElementById('especialidade').value;
            const especialidadeOutra = document.getElementById('especialidade_outra').value;
            const telefone = document.getElementById('telefone').value.replace(/\D/g, '');
            
            if (especialidade === 'Outra' && especialidadeOutra.trim() === '') {
                alert('Por favor, especifique a especialidade!');
                e.preventDefault();
                return false;
            }
            
            if (telefone.length < 10 || telefone.length > 11) {
                alert('Telefone deve ter 10 ou 11 dígitos!');
                e.preventDefault();
                return false;
            }

            // Se especialidade for "Outra", usar o valor do campo personalizado
            if (especialidade === 'Outra') {
                document.getElementById('especialidade').value = especialidadeOutra;
            }
        });

        // Formatação automática do CRM
        document.getElementById('crm').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            // Permite letras, números, barras e espaços
            value = value.replace(/[^A-Z0-9\/\s]/g, '');
            e.target.value = value;
        });
    </script>
</body>
</html>
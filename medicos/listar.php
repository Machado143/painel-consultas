<?php
include_once '../conexao.php';

// Verificar se a conexão está funcionando
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$sql = "SELECT * FROM medicos ORDER BY nome";
$resultado = $conn->query($sql);

// Verificar se a query foi executada com sucesso
if (!$resultado) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Médicos - Sistema Médico</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-md"></i> Lista de Médicos</h1>
        
        <div class="nav-links">
            <a href="cadastrar.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Médico
            </a>
            <a href="../index.php" class="btn">
                <i class="fas fa-home"></i> Início
            </a>
        </div>

        <div class="table-container">
            <?php if ($resultado->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Nome</th>
                            <th><i class="fas fa-id-badge"></i> CRM</th>
                            <th><i class="fas fa-stethoscope"></i> Especialidade</th>
                            <th><i class="fas fa-phone"></i> Telefone</th>
                            <th><i class="fas fa-cogs"></i> Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($medico = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($medico['id']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($medico['nome']) ?></strong>
                            </td>
                            <td>
                                <span class="badge"><?= htmlspecialchars($medico['crm']) ?></span>
                            </td>
                            <td>
                                <i class="fas fa-circle text-success"></i>
                                <?= htmlspecialchars($medico['especialidade']) ?>
                            </td>
                            <td>
                                <?php 
                                $telefone = $medico['telefone'];
                                if (strlen($telefone) == 11) {
                                    $telefone_formatado = preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
                                } elseif (strlen($telefone) == 10) {
                                    $telefone_formatado = preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
                                } else {
                                    $telefone_formatado = $telefone;
                                }
                                ?>
                                <i class="fas fa-phone-alt"></i>
                                <?= htmlspecialchars($telefone_formatado) ?>
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="editar.php?id=<?= $medico['id'] ?>" class="action-link action-edit">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <a href="excluir.php?id=<?= $medico['id'] ?>" 
                                       class="action-link action-delete" 
                                       onclick="return confirm('Tem certeza que deseja excluir o médico <?= htmlspecialchars($medico['nome']) ?>?\n\nATENÇÃO: Todas as consultas associadas também serão removidas!');">
                                        <i class="fas fa-trash"></i> Excluir
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number"><?= $resultado->num_rows ?></div>
                        <div class="stat-label">Médicos Cadastrados</div>
                    </div>
                </div>
                
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Nenhum médico cadastrado!</strong><br>
                    Clique em "Novo Médico" para cadastrar o primeiro médico do sistema.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .badge {
            background: var(--secondary-color);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .text-success {
            color: var(--success-color);
        }
        
        tbody tr:hover {
            background: rgba(52, 152, 219, 0.08);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }
    </style>

    <script>
        // Efeito de hover mais suave nas linhas da tabela
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>
</body>
</html>
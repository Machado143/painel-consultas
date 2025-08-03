<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Agendamento Médico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="container">
        <h1><i class="fas fa-hospital"></i> Sistema de Agendamento Médico</h1>

        <?php
        include_once 'conexao.php';

        $total_pacientes = $conn->query("SELECT COUNT(*) as total FROM pacientes")->fetch_assoc()['total'];
        $total_medicos = $conn->query("SELECT COUNT(*) as total FROM medicos")->fetch_assoc()['total'];
        $total_consultas = $conn->query("SELECT COUNT(*) as total FROM consultas")->fetch_assoc()['total'];
        $consultas_hoje = $conn->query("SELECT COUNT(*) as total FROM consultas WHERE DATE(data) = CURDATE()")->fetch_assoc()['total'];
        ?>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= number_format($total_pacientes) ?></div>
                <div class="stat-label">Pacientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= number_format($total_medicos) ?></div>
                <div class="stat-label">Médicos</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= number_format($total_consultas) ?></div>
                <div class="stat-label">Consultas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= number_format($consultas_hoje) ?></div>
                <div class="stat-label">Hoje</div>
            </div>
        </div>

        <!-- Cards de Navegação -->
        <div class="dashboard">

            <!-- Card Pacientes -->
            <div class="card">
                <div class="card-header">
                    <h3>Pacientes</h3>
                    <i class="fas fa-user-injured"></i>
                </div>
                <div class="card-body">
                    <p>Gerencie os registros dos pacientes, incluindo cadastro, edição e histórico médico. Mantenha todas as informações atualizadas para um atendimento eficiente.</p>
                    <div class="nav-links">
                        <a href="pacientes/listar.php" class="btn">
                            <i class="fas fa-list"></i> Ver Pacientes
                        </a>
                        <a href="pacientes/cadastrar.php" class="btn btn-success">
                            <i class="fas fa-plus"></i> Novo Paciente
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Médicos -->
            <div class="card">
                <div class="card-header">
                    <h3>Médicos</h3>
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="card-body">
                    <p>Administre o cadastro de médicos, especialidades e informações de contato. Organize a equipe médica para um melhor gerenciamento de consultas.</p>
                    <div class="nav-links">
                        <a href="medicos/listar.php" class="btn">
                            <i class="fas fa-list"></i> Ver Médicos
                        </a>
                        <a href="medicos/cadastrar.php" class="btn btn-success">
                            <i class="fas fa-plus"></i> Novo Médico
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card Consultas -->
            <div class="card">
                <div class="card-header">
                    <h3>Consultas</h3>
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-body">
                    <p>Agende e acompanhe as consultas médicas com histórico completo de atendimentos. Organize a agenda médica de forma eficiente.</p>
                    <div class="nav-links">
                        <a href="consultas/listar.php" class="btn">
                            <i class="fas fa-list"></i> Ver Consultas
                        </a>
                        <a href="consultas/agendar.php" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nova Consulta
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consultas de Hoje -->
        <div class="form-container">
            <h2><i class="fas fa-calendar-day"></i> Consultas de Hoje - <?= date('d/m/Y') ?></h2>

            <?php
            $consultas_hoje_query = $conn->query("
                SELECT consultas.id, pacientes.nome AS paciente, medicos.nome AS medico, 
                       consultas.horario, consultas.observacoes
                FROM consultas
                JOIN pacientes ON consultas.paciente_id = pacientes.id
                JOIN medicos ON consultas.medico_id = medicos.id
                WHERE DATE(consultas.data) = CURDATE()
                ORDER BY consultas.horario
            ");
            ?>

            <?php if ($consultas_hoje_query->num_rows > 0): ?>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th><i class="fas fa-clock"></i> Horário</th>
                                <th><i class="fas fa-user"></i> Paciente</th>
                                <th><i class="fas fa-user-md"></i> Médico</th>
                                <th><i class="fas fa-notes-medical"></i> Observações</th>
                                <th><i class="fas fa-cogs"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($consulta = $consultas_hoje_query->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?= date('H:i', strtotime($consulta['horario'])) ?></strong></td>
                                <td><?= htmlspecialchars($consulta['paciente']) ?></td>
                                <td><?= htmlspecialchars($consulta['medico']) ?></td>
                                <td><?= htmlspecialchars($consulta['observacoes'] ?: 'Sem observações') ?></td>
                                <td>
                                    <div class="actions">
                                        <a href="consultas/editar.php?id=<?= $consulta['id'] ?>" class="action-link action-edit">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i>
                    Não há consultas agendadas para hoje.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p><i class="fas fa-code"></i> Sistema desenvolvido por Gabriel Machado | <i class="fas fa-heart"></i> Feito com PHP & MySQL</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 200);
            });
        });

        setInterval(function() {
            fetch('health-check.php')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'ok') {
                        console.log('Sistema funcionando normalmente');
                    }
                })
                .catch(error => {
                    console.log('Erro ao verificar status do sistema');
                });
        }, 30000);
    </script>
</body>
</html>

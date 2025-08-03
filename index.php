<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Consultas Médicas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --text-color: #333;
            --light-bg: #f8f9fa;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: var(--primary-color);
            color: var(--white);
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px 0;
        }

        .card {
            background: var(--white);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .card-header {
            background: var(--secondary-color);
            color: var(--white);
            padding: 20px;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header i {
            font-size: 2rem;
        }

        .card-body {
            padding: 25px;
        }

        .btn {
            display: inline-block;
            background: var(--secondary-color);
            color: var(--white);
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }

        .btn i {
            margin-right: 8px;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: var(--text-color);
            font-size: 0.9rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }
            
            .dashboard {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <h2>Sistema de Agendamento Médico</h2>
        </div>
    </header>

    <main class="container">
        <div class="dashboard">
            <div class="card">
                <div class="card-header">
                    <span>Pacientes</span>
                    <i class="fas fa-user-injured"></i>
                </div>
                <div class="card-body">
                    <p>Gerencie os registros dos pacientes, incluindo cadastro, edição e histórico médico.</p>
                    <a href="pacientes/listar.php" class="btn"><i class="fas fa-list"></i> Acessar</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span>Médicos</span>
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="card-body">
                    <p>Administre o cadastro de médicos, especialidades e disponibilidades para consultas.</p>
                    <a href="medicos/listar.php" class="btn"><i class="fas fa-list"></i> Acessar</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <span>Consultas</span>
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="card-body">
                    <p>Agende e acompanhe as consultas médicas, com histórico completo de atendimentos.</p>
                    <a href="consultas/listar.php" class="btn"><i class="fas fa-list"></i> Acessar</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>Sistema desenvolvido por Gabriel Machado</p>
        </div>
    </footer>
</body>
</html>

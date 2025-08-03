-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS painel_consultas;

-- Usar o banco de dados criado
USE painel_consultas;

-- Criar tabela de pacientes
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    data_nascimento DATE NOT NULL,
    genero ENUM('M', 'F', 'O') NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

-- Criar tabela de médicos (com campo telefone adicionado)
CREATE TABLE medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    crm VARCHAR(20) UNIQUE NOT NULL,
    especialidade VARCHAR(50) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

-- Criar tabela de consultas
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    medico_id INT NOT NULL,
    data DATE NOT NULL,
    horario TIME NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    FOREIGN KEY (medico_id) REFERENCES medicos(id) ON DELETE CASCADE
);

-- Inserir dados fictícios para teste
-- Pacientes de exemplo
INSERT INTO pacientes (nome, cpf, data_nascimento, genero, email, telefone) VALUES
('João Silva', '12345678901', '1985-05-15', 'M', 'joao.silva@email.com', '11987654321'),
('Maria Santos', '98765432100', '1990-08-22', 'F', 'maria.santos@email.com', '11876543210'),
('Pedro Oliveira', '11122233344', '1978-12-03', 'M', 'pedro.oliveira@email.com', '11955667788'),
('Ana Paula Costa', '22233344455', '1995-03-18', 'F', 'ana.costa@email.com', '11944556677'),
('Carlos Eduardo', '33344455566', '1982-07-25', 'M', 'carlos.eduardo@email.com', '11933445566'),
('Fernanda Lima', '44455566677', '1988-11-12', 'F', 'fernanda.lima@email.com', '11922334455'),
('Roberto Alves', '55566677788', '1975-09-30', 'M', 'roberto.alves@email.com', '11911223344'),
('Juliana Pereira', '66677788899', '1992-01-08', 'F', 'juliana.pereira@email.com', '11900112233'),
('Marcos Antonio', '77788899900', '1980-04-14', 'M', 'marcos.antonio@email.com', '11999887766'),
('Patricia Souza', '88899900011', '1987-06-27', 'F', 'patricia.souza@email.com', '11988776655'),
('Luis Fernando', '99900011122', '1983-10-05', 'M', 'luis.fernando@email.com', '11977665544'),
('Camila Rodrigues', '10011122233', '1994-02-19', 'F', 'camila.rodrigues@email.com', '11966554433');

-- Médicos de exemplo
INSERT INTO medicos (nome, crm, especialidade, telefone) VALUES
('Dr. Carlos Oliveira', 'CRM123456', 'Cardiologia', '1133334444'),
('Dra. Ana Costa', 'CRM789012', 'Dermatologia', '1155556666'),
('Dr. Paulo Mendes', 'CRM345678', 'Ortopedia', '1144445555'),
('Dra. Lucia Ferreira', 'CRM901234', 'Ginecologia', '1166667777'),
('Dr. Ricardo Santos', 'CRM567890', 'Neurologia', '1177778888'),
('Dra. Mariana Silva', 'CRM234567', 'Pediatria', '1188889999'),
('Dr. Fernando Costa', 'CRM678901', 'Oftalmologia', '1199990000'),
('Dra. Beatriz Lima', 'CRM890123', 'Psiquiatria', '1100001111'),
('Dr. Rodrigo Almeida', 'CRM456789', 'Urologia', '1111112222'),
('Dra. Cristina Rocha', 'CRM012345', 'Endocrinologia', '1122223333');

-- Consultas de exemplo
INSERT INTO consultas (paciente_id, medico_id, data, horario, observacoes) VALUES
-- Consultas para agosto de 2025
(1, 1, '2025-08-05', '08:00:00', 'Consulta de rotina - pressão arterial elevada'),
(2, 2, '2025-08-05', '09:30:00', 'Avaliação de manchas na pele'),
(3, 3, '2025-08-05', '14:00:00', 'Dor no joelho direito - investigar lesão'),
(4, 4, '2025-08-06', '08:30:00', 'Exame preventivo anual'),
(5, 5, '2025-08-06', '10:00:00', 'Dores de cabeça frequentes'),
(6, 6, '2025-08-06', '15:30:00', 'Consulta pediátrica - vacinas em dia'),
(7, 7, '2025-08-07', '09:00:00', 'Exame de vista - possível miopia'),
(8, 8, '2025-08-07', '11:00:00', 'Acompanhamento psiquiátrico'),
(9, 9, '2025-08-07', '16:00:00', 'Consulta urológica - exames de rotina'),
(10, 10, '2025-08-08', '08:00:00', 'Diabetes - ajuste de medicação'),
(11, 1, '2025-08-08', '10:30:00', 'Retorno cardiológico - novos exames'),
(12, 2, '2025-08-08', '14:30:00', 'Tratamento de acne'),
(1, 3, '2025-08-09', '09:00:00', 'Fisioterapia - avaliação ortopédica'),
(2, 4, '2025-08-09', '11:30:00', 'Planejamento familiar'),
(3, 5, '2025-08-09', '15:00:00', 'Resultado de exames neurológicos'),
(4, 6, '2025-08-10', '08:30:00', 'Consulta pediátrica - crescimento'),
(5, 7, '2025-08-10', '10:00:00', 'Cirurgia de catarata - pré-operatório'),
(6, 8, '2025-08-10', '16:30:00', 'Terapia cognitiva comportamental'),
(7, 9, '2025-08-11', '09:30:00', 'Exame de próstata'),
(8, 10, '2025-08-11', '14:00:00', 'Consulta endocrinológica - tireoide'),
(9, 1, '2025-08-12', '08:00:00', 'Eletrocardiograma de controle'),
(10, 2, '2025-08-12', '11:00:00', 'Dermatite atópica - acompanhamento'),
(11, 3, '2025-08-12', '15:30:00', 'Artroscopia - pós-operatório'),
(12, 4, '2025-08-13', '09:00:00', 'Ultrassom pélvico'),
(1, 5, '2025-08-13', '13:30:00', 'Enxaqueca - nova medicação'),
-- Consultas futuras (setembro)
(2, 6, '2025-09-02', '08:00:00', 'Consulta de rotina pediátrica'),
(3, 7, '2025-09-03', '10:30:00', 'Cirurgia de catarata - pós-operatório'),
(4, 8, '2025-09-04', '14:00:00', 'Sessão de psicoterapia'),
(5, 9, '2025-09-05', '09:00:00', 'Exames urológicos de controle'),
(6, 10, '2025-09-06', '11:30:00', 'Diabetes - consulta trimestral');
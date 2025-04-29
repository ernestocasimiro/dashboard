-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Abr-2025 às 21:43
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `escolabd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(127) NOT NULL,
  `lname` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `fname`, `lname`) VALUES
(3, 'ernestocasimiro', '$2y$10$NG6J0mB1AJs3RBbQYhQyyuCmKt91pQI7SHidf.scdDGNMxH.JbSwO', 'Ernesto Miguel', 'Casimiro\r\n'),
(4, 'danielsalazar', '$2y$10$NG6J0mB1AJs3RBbQYhQyyuCmKt91pQI7SHidf.scdDGNMxH.JbSwO', 'Daniel', 'Salazar'),
(5, 'steevesalvador', '$2y$10$NG6J0mB1AJs3RBbQYhQyyuCmKt91pQI7SHidf.scdDGNMxH.JbSwO', 'Steeve', 'Salvador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `guardians`
--

CREATE TABLE `guardians` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('Masculino','Feminino','Outro') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `bi_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `guardians`
--

INSERT INTO `guardians` (`id`, `name`, `gender`, `dob`, `bi_number`, `address`, `contact`, `email`, `created_at`, `updated_at`) VALUES
(13, 'Luís Casimiro', 'Masculino', '2025-04-08', '1234567LA123', 'Kilamba', '+244 947556362', 'luiscasimiro@gmail.com', '2025-04-16 23:19:09', '2025-04-16 23:19:09'),
(14, 'Ernesto Miguel Casimiro', 'Masculino', '2025-04-09', '7363672LA133', 'Morro Bento', '+244 943800930', 'ernesto@gmail.com', '2025-04-16 23:26:20', '2025-04-16 23:26:20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `turma_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_code` varchar(10) NOT NULL COMMENT 'Código curto da disciplina (ex: LP, MAT)',
  `subject_name` varchar(100) NOT NULL COMMENT 'Nome completo da disciplina',
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `subjects`
--

INSERT INTO `subjects` (`id`, `subject_code`, `subject_name`, `description`, `is_active`) VALUES
(1, 'LP', 'Língua Portuguesa', NULL, 1),
(2, 'MAT', 'Matemática', NULL, 1),
(3, 'FIS', 'Física', NULL, 1),
(4, 'TLP', 'Técnica de Linguagem de Programação', NULL, 1),
(5, 'TIC', 'Tecnologia de Informação e Comunicação', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `gender` enum('Masculino','Feminino','Outro') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `bi_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `teachers`
--

INSERT INTO `teachers` (`id`, `fname`, `lname`, `username`, `gender`, `dob`, `bi_number`, `address`, `contact`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'ernesto', 'casimiro', 'ernesto', 'Masculino', '1999-05-21', '1234567LA123', 'Kilamba', '+244 947 556 362', 'ernesto@gmail.com', '$2y$10$FEasWwpPtKRxXBb2h/vW8u5TZEfe1qHwmbUqvAKZ393L4bdCOUQ8q', '2025-04-21 18:57:39', '2025-04-21 18:57:39');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teacher_subjects`
--

CREATE TABLE `teacher_subjects` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ano` varchar(10) NOT NULL,
  `capacidade` int(11) NOT NULL DEFAULT 25,
  `diretor_id` int(11) DEFAULT NULL,
  `turno` enum('manha','tarde','noite') DEFAULT 'manha',
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices para tabela `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turma_id` (`turma_id`);

--
-- Índices para tabela `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`);

--
-- Índices para tabela `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices para tabela `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`,`subject_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Índices para tabela `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diretor_id` (`diretor_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `guardians`
--
ALTER TABLE `guardians`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `teacher_subjects`
--
ALTER TABLE `teacher_subjects`
  ADD CONSTRAINT `teacher_subjects_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `turmas`
--
ALTER TABLE `turmas`
  ADD CONSTRAINT `turmas_ibfk_1` FOREIGN KEY (`diretor_id`) REFERENCES `teachers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

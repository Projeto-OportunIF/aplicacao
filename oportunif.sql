-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/11/2025 às 02:59
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `oportunif`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `idCursos` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`idCursos`, `nome`) VALUES
(1, 'Técnico em Desenvolvimento de Sistemas (TDS)'),
(3, 'Técnico em Edificações'),
(4, 'Técnico em Aquicultura'),
(5, 'Técnico em Meio Ambiente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `inscricoes`
--

CREATE TABLE `inscricoes` (
  `idInscricoes` int(11) NOT NULL,
  `documentosAnexo` varchar(100) DEFAULT NULL,
  `feedbackProfessor` text DEFAULT NULL,
  `status` enum('PENDENTE','APROVADO','REPROVADO') DEFAULT NULL,
  `idOportunidades` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL,
  `dataInscricao` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `inscricoes`
--

INSERT INTO `inscricoes` (`idInscricoes`, `documentosAnexo`, `feedbackProfessor`, `status`, `idOportunidades`, `idUsuarios`, `dataInscricao`) VALUES
(41, '', NULL, 'PENDENTE', 38, 39, '2025-11-24 22:55:50'),
(42, '', NULL, 'PENDENTE', 38, 40, '2025-11-24 22:56:16'),
(43, '', 'O aluno foi oficialmente aprovado para participar da oportunidade de extensão \'Clube da Música\', estando autorizado a integrar as atividades musicais do projeto.', 'APROVADO', 38, 33, '2025-11-24 22:56:43'),
(44, '', NULL, 'PENDENTE', 38, 38, '2025-11-24 22:56:56');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `idNotificacoes` int(11) NOT NULL,
  `mensagem` longtext NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `dataEnvio` date NOT NULL,
  `idOportunidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notificacoes`
--

INSERT INTO `notificacoes` (`idNotificacoes`, `mensagem`, `link`, `dataEnvio`, `idOportunidade`) VALUES
(28, 'Uma nova oportunidade foi criada: Monitoramento da Qualidade da Água em Sistemas Aquícola', NULL, '2025-11-25', 36),
(29, 'Uma nova oportunidade foi criada: Estágio em Desenvolvimento Web com PHP', NULL, '2025-11-25', 37),
(30, 'Uma nova oportunidade foi criada: Projeto Clube da Música – Vivências Artísticas no IFPR', NULL, '2025-11-25', 38),
(31, 'Um novo aluno se inscreveu na sua oportunidade \"Projeto Clube da Música – Vivências Artísticas no IFPR\".', '/aplicacao/app/controller/InscricaoController.php?action=listarInscritos&idOport=38', '2025-11-24', 38),
(32, 'Um novo aluno se inscreveu na sua oportunidade \"Projeto Clube da Música – Vivências Artísticas no IFPR\".', '/aplicacao/app/controller/InscricaoController.php?action=listarInscritos&idOport=38', '2025-11-24', 38),
(33, 'Um novo aluno se inscreveu na sua oportunidade \"Projeto Clube da Música – Vivências Artísticas no IFPR\".', '/aplicacao/app/controller/InscricaoController.php?action=listarInscritos&idOport=38', '2025-11-24', 38),
(34, 'Um novo aluno se inscreveu na sua oportunidade \"Projeto Clube da Música – Vivências Artísticas no IFPR\".', '/aplicacao/app/controller/InscricaoController.php?action=listarInscritos&idOport=38', '2025-11-24', 38);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes_usuarios`
--

CREATE TABLE `notificacoes_usuarios` (
  `idNotificacao` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `status` enum('ENVIADO','LIDO') DEFAULT 'ENVIADO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notificacoes_usuarios`
--

INSERT INTO `notificacoes_usuarios` (`idNotificacao`, `idUsuario`, `status`) VALUES
(28, 33, 'ENVIADO'),
(28, 39, 'ENVIADO'),
(28, 40, 'ENVIADO'),
(29, 33, 'ENVIADO'),
(30, 33, 'ENVIADO'),
(30, 38, 'ENVIADO'),
(30, 39, 'ENVIADO'),
(30, 40, 'ENVIADO'),
(31, 41, 'ENVIADO'),
(32, 41, 'ENVIADO'),
(33, 41, 'ENVIADO'),
(34, 41, 'ENVIADO');

-- --------------------------------------------------------

--
-- Estrutura para tabela `oportunidades`
--

CREATE TABLE `oportunidades` (
  `idOportunidades` int(11) NOT NULL,
  `titulo` longtext DEFAULT NULL,
  `descricao` longtext DEFAULT NULL,
  `tipoOportunidade` enum('ESTAGIO','PROJETOEXTENSAO','PROJETOPESQUISA') NOT NULL,
  `dataInicio` date NOT NULL,
  `dataFim` date NOT NULL,
  `documentoAnexo` varchar(100) DEFAULT NULL,
  `vaga` int(11) NOT NULL,
  `documentoEdital` varchar(255) DEFAULT NULL,
  `idProfessor` int(11) NOT NULL DEFAULT 38
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `oportunidades`
--

INSERT INTO `oportunidades` (`idOportunidades`, `titulo`, `descricao`, `tipoOportunidade`, `dataInicio`, `dataFim`, `documentoAnexo`, `vaga`, `documentoEdital`, `idProfessor`) VALUES
(36, 'Monitoramento da Qualidade da Água em Sistemas Aquícola', '<p>Projeto de pesquisa voltado para an&aacute;lise de par&acirc;metros f&iacute;sico-qu&iacute;micos da &aacute;gua em tanques de aquicultura. Os participantes ir&atilde;o coletar dados em campo, registrar resultados e auxiliar na elabora&ccedil;&atilde;o de relat&oacute;rios t&eacute;cnicos.</p>', 'PROJETOPESQUISA', '2025-10-31', '2025-12-04', 'medições físico-químicas da água', 12, 'edital_6925087b2dea3_APznzabZKnOeF2yWfPLHaFNUXS7OsrKkRdJbybBSQpUc6GYN-IxZs9tpxlmEe01q9tQjsq78xrSrfaTFK6ILAZBWU365gNsg0uekPvPVhDxd2Zx-68aOr2KBU8seKqo2uCwCmvq5FLRECncEwZsDCXtsRRMiHcTUuGzkF1YLghP2fSteRufSDxhrRBc3Kg.pdf', 37),
(37, 'Estágio em Desenvolvimento Web com PHP', '<p>O estudante atuar&aacute; no suporte ao desenvolvimento de sistemas internos, realizando manuten&ccedil;&atilde;o de c&oacute;digo, cria&ccedil;&atilde;o de novas funcionalidades e testes. Necess&aacute;rio conhecimento b&aacute;sico em PHP, HTML, CSS e MySQL.</p>', 'ESTAGIO', '2025-10-30', '2025-11-20', '', 3, 'edital_69250ba8a8276_APznzabZKnOeF2yWfPLHaFNUXS7OsrKkRdJbybBSQpUc6GYN-IxZs9tpxlmEe01q9tQjsq78xrSrfaTFK6ILAZBWU365gNsg0uekPvPVhDxd2Zx-68aOr2KBU8seKqo2uCwCmvq5FLRECncEwZsDCXtsRRMiHcTUuGzkF1YLghP2fSteRufSDxhrRBc3Kg.pdf', 37),
(38, 'Projeto Clube da Música – Vivências Artísticas no IFPR', '<p>Atividade de extens&atilde;o aberta a todos os estudantes interessados em m&uacute;sica. Os participantes poder&atilde;o aprender instrumentos, participar de ensaios, colaborar com apresenta&ccedil;&otilde;es internas e desenvolver habilidades art&iacute;sticas e colaborativas.</p>', 'PROJETOEXTENSAO', '2025-10-29', '2025-12-03', '', 60, 'edital_69250bf8cbbe2_APznzabZKnOeF2yWfPLHaFNUXS7OsrKkRdJbybBSQpUc6GYN-IxZs9tpxlmEe01q9tQjsq78xrSrfaTFK6ILAZBWU365gNsg0uekPvPVhDxd2Zx-68aOr2KBU8seKqo2uCwCmvq5FLRECncEwZsDCXtsRRMiHcTUuGzkF1YLghP2fSteRufSDxhrRBc3Kg.pdf', 41);

-- --------------------------------------------------------

--
-- Estrutura para tabela `oportunidade_curso`
--

CREATE TABLE `oportunidade_curso` (
  `id` int(11) NOT NULL,
  `idOportunidade` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `oportunidade_curso`
--

INSERT INTO `oportunidade_curso` (`id`, `idOportunidade`, `idCurso`) VALUES
(95, 37, 1),
(96, 38, 4),
(97, 38, 1),
(98, 38, 3),
(99, 38, 5),
(100, 36, 4),
(101, 36, 1),
(102, 36, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL,
  `nomeCompleto` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipoUsuario` enum('ALUNO','PROFESSOR','ADMIN') NOT NULL,
  `matricula` varchar(45) DEFAULT NULL,
  `idCursos` int(11) DEFAULT NULL,
  `fotoPerfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUsuarios`, `nomeCompleto`, `email`, `cpf`, `senha`, `tipoUsuario`, `matricula`, `idCursos`, `fotoPerfil`) VALUES
(1, 'Roberta Silva', 'robertasilva@gmail.com', '123.456.789-00', '$2a$12$1BDqobBHZGsw4dmj7lXgluXvyz.dnUFljz.1yc9BH8Va0xGVeyP9G', 'ADMIN', '', NULL, 'arquivo_68af3b57e44c4.jpeg'),
(33, 'julie', 'julie@gmail.com', '105.296.209-28', '$2y$10$6buEjUyc6irPaFWsQmYm7u5lFs5nhx.80q1hFntBtXfbILj.IJxLi', 'ALUNO', '20223024000', 1, NULL),
(37, 'Jefersson', 'Jefersson@gmail.com', '552.405.190-30', '$2y$10$vxxb2fZ3uBT0izbw0yj02egeyqC2QkPA/M/0Cn6pLRbmj0Kr7GeYu', 'PROFESSOR', '345678', 1, NULL),
(38, 'Daniel Di Domenico', 'daniel@gmail.com', '968.353.650-64', '$2y$10$kCITd0R0ip6Yn3WkW4CkZufS/BwKU5u9WWatXBoBwQO3fcJ9v8HbK', 'ALUNO', '123456', 3, NULL),
(39, 'Ana Carla Ahuda', 'anacarla@gmail.com', '317.818.880-00', '$2y$10$4cOgiyTYD48E9GxbTFTkHez4IV0PUZm47OjkToTTOAJzNRZxFy1zK', 'ALUNO', '1234567', 5, NULL),
(40, 'Julio Royer', 'julio@gmail.com', '632.342.900-40', '$2y$10$GzA0yfnKqOeQM6EcbIzbiO9vE4C.kR/nxt9KFBCYvTE5DGqVpi6Xa', 'ALUNO', '12345678', 4, NULL),
(41, 'Isabela Martins', 'isa@gmail.com', '867.929.270-23', '$2y$10$z3kHM8v8Jk54q.K0DtJDuuEmp8lP3tKl6WzZ8zvhnmh1nF1UIffZq', 'PROFESSOR', '7654321', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`idCursos`);

--
-- Índices de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD PRIMARY KEY (`idInscricoes`),
  ADD KEY `fk_inscricoes_usuarios1` (`idUsuarios`),
  ADD KEY `fk_inscricoes_oportunidades1_cascade` (`idOportunidades`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`idNotificacoes`),
  ADD KEY `fk_notificacoes_oportunidade` (`idOportunidade`);

--
-- Índices de tabela `notificacoes_usuarios`
--
ALTER TABLE `notificacoes_usuarios`
  ADD KEY `fk_notif_user_usuario` (`idUsuario`),
  ADD KEY `fk_notif_user_notificacao` (`idNotificacao`);

--
-- Índices de tabela `oportunidades`
--
ALTER TABLE `oportunidades`
  ADD PRIMARY KEY (`idOportunidades`),
  ADD KEY `fk_professor` (`idProfessor`);

--
-- Índices de tabela `oportunidade_curso`
--
ALTER TABLE `oportunidade_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idOportunidade` (`idOportunidade`),
  ADD KEY `idCurso` (`idCurso`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuarios`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuarios_cursos1` (`idCursos`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `idCursos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `inscricoes`
--
ALTER TABLE `inscricoes`
  MODIFY `idInscricoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `idNotificacoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `oportunidades`
--
ALTER TABLE `oportunidades`
  MODIFY `idOportunidades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `oportunidade_curso`
--
ALTER TABLE `oportunidade_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `inscricoes`
--
ALTER TABLE `inscricoes`
  ADD CONSTRAINT `fk_inscricoes_oportunidades1_cascade` FOREIGN KEY (`idOportunidades`) REFERENCES `oportunidades` (`idOportunidades`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inscricoes_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscricoes_usuarios_cascade` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `fk_notificacoes_oportunidade` FOREIGN KEY (`idOportunidade`) REFERENCES `oportunidades` (`idOportunidades`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `notificacoes_usuarios`
--
ALTER TABLE `notificacoes_usuarios`
  ADD CONSTRAINT `fk_notif_user_notificacao` FOREIGN KEY (`idNotificacao`) REFERENCES `notificacoes` (`idNotificacoes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notif_user_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `oportunidades`
--
ALTER TABLE `oportunidades`
  ADD CONSTRAINT `fk_professor` FOREIGN KEY (`idProfessor`) REFERENCES `usuarios` (`idUsuarios`);

--
-- Restrições para tabelas `oportunidade_curso`
--
ALTER TABLE `oportunidade_curso`
  ADD CONSTRAINT `oportunidade_curso_ibfk_1` FOREIGN KEY (`idOportunidade`) REFERENCES `oportunidades` (`idOportunidades`) ON DELETE CASCADE,
  ADD CONSTRAINT `oportunidade_curso_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCursos`) ON DELETE CASCADE;

--
-- Restrições para tabelas `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_cursos1` FOREIGN KEY (`idCursos`) REFERENCES `cursos` (`idCursos`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

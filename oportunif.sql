-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/10/2025 às 20:18
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
  `feedbackProfessor` varchar(45) DEFAULT NULL,
  `status` enum('PENDENTE','APROVADO','REPROVADO') DEFAULT NULL,
  `idOportunidades` int(11) NOT NULL,
  `idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `idNotificacoes` int(11) NOT NULL,
  `mensagem` varchar(45) NOT NULL,
  `dataEnvio` date NOT NULL,
  `status` enum('ENVIADO','LIDO') NOT NULL,
  `idUsuarios` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes_usuarios`
--

CREATE TABLE `notificacoes_usuarios` (
  `idNotificacao` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `notificacoes_usuarios`
--

INSERT INTO `notificacoes_usuarios` (`idNotificacao`, `idUsuario`) VALUES
(1, 33),
(2, 33),
(14, 33),
(14, 34);

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
  `professor_responsavel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `oportunidades`
--

INSERT INTO `oportunidades` (`idOportunidades`, `titulo`, `descricao`, `tipoOportunidade`, `dataInicio`, `dataFim`, `documentoAnexo`, `vaga`, `professor_responsavel`) VALUES
(23, 'Teatro em Cena: Expressão, Cultura e Cidadania', '<p data-start=\"192\" data-end=\"633\" data-pasted=\"true\">O projeto <strong data-start=\"202\" data-end=\"254\">&ldquo;Teatro em Cena: Express&atilde;o, Cultura e Cidadania&rdquo;</strong> tem como objetivo promover a arte teatral como ferramenta de transforma&ccedil;&atilde;o social, incentivando a express&atilde;o pessoal, o pensamento cr&iacute;tico e o fortalecimento da cidadania. As apresenta&ccedil;&otilde;es teatrais resultantes das oficinas ser&atilde;o abertas ao p&uacute;blico, valorizando o protagonismo dos participantes e o di&aacute;logo com a comunidade.</p>', 'PROJETOEXTENSAO', '2025-09-04', '2025-11-22', 'certificado de teatro; certificado em artes cenicas', 20, 'Givaldo'),
(25, 'Oportunidade de Estágio — Desenvolvimento Web no IFPR', '<p data-start=\"168\" data-end=\"488\" data-pasted=\"true\">Estamos divulgando uma vaga de <strong data-start=\"216\" data-end=\"277\">Est&aacute;gio em Tecnologia da Informa&ccedil;&atilde;o / Desenvolvimento Web</strong> em Curitiba. O estagi&aacute;rio vai atuar no suporte de projetos digitais, manuten&ccedil;&atilde;o de sistemas internos, implementa&ccedil;&atilde;o de novas funcionalidades e corre&ccedil;&atilde;o de bugs, sempre sob supervis&atilde;o de um profissional da &aacute;rea.</p><p data-start=\"490\" data-end=\"869\"><strong data-start=\"490\" data-end=\"515\">Exemplo real de vaga:</strong><br data-start=\"515\" data-end=\"518\">Est&aacute;gio TI &ndash; Dados / IA / Automa&ccedil;&atilde;o &mdash; Curitiba (INTERTECHNE Consultores) <span data-state=\"closed\"><span data-testid=\"webpage-citation-pill\"><a href=\"https://br.indeed.com/q-est%C3%A1gio-tecnologia-informa%C3%A7%C3%A3o-l-curitiba%2C-pr-vagas.html?utm_source=chatgpt.com\" target=\"_blank\" rel=\"noopener\" alt=\"https://br.indeed.com/q-est%C3%A1gio-tecnologia-informa%C3%A7%C3%A3o-l-curitiba%2C-pr-vagas.html?utm_source=chatgpt.com\">Indeed+2Indeed+2</a></span></span><br data-start=\"628\" data-end=\"631\">Voc&ecirc; pode ver mais detalhes e se inscrever aqui: <strong data-start=\"680\" data-end=\"829\"><a data-start=\"682\" data-end=\"827\" rel=\"noopener\" target=\"_new\">Vaga no Indeed / Intertechne &ndash; Est&aacute;gio TI</a></strong> <span data-state=\"closed\"><span data-testid=\"webpage-citation-pill\"><a href=\"https://br.indeed.com/q-est%C3%A1gio-tecnologia-informa%C3%A7%C3%A3o-l-curitiba%2C-pr-vagas.html?utm_source=chatgpt.com\" target=\"_blank\" rel=\"noopener\" alt=\"https://br.indeed.com/q-est%C3%A1gio-tecnologia-informa%C3%A7%C3%A3o-l-curitiba%2C-pr-vagas.html?utm_source=chatgpt.com\">Indeed</a></span></span></p><p data-start=\"871\" data-end=\"888\"><strong data-start=\"871\" data-end=\"886\">Requisitos:</strong></p><ul data-start=\"889\" data-end=\"1133\"><li data-start=\"889\" data-end=\"1015\"><p data-start=\"891\" data-end=\"1015\">Estar matriculado em curso de Tecnologia da Informa&ccedil;&atilde;o, Sistemas da Informa&ccedil;&atilde;o, Ci&ecirc;ncia da Computa&ccedil;&atilde;o ou &aacute;reas correlatas;</p></li><li data-start=\"1016\" data-end=\"1076\"><p data-start=\"1018\" data-end=\"1076\">Conhecimentos b&aacute;sicos em <strong data-start=\"1043\" data-end=\"1073\">HTML, CSS, JavaScript, SQL</strong>;</p></li><li data-start=\"1077\" data-end=\"1133\"><p data-start=\"1079\" data-end=\"1133\">Proatividade, vontade de aprender e boa comunica&ccedil;&atilde;o.</p></li></ul>', 'ESTAGIO', '2025-06-12', '2026-01-28', '', 2, 'Jefferson Chaves'),
(26, 'Biodiversidade e Conservação de Plantas Nativas', '<p>O projeto de pesquisa &ldquo;Biodiversidade e Conserva&ccedil;&atilde;o de Plantas Nativas&rdquo; tem como objetivo identificar, catalogar e analisar esp&eacute;cies vegetais presentes em &aacute;reas de preserva&ccedil;&atilde;o do estado do Paran&aacute;. O aluno pesquisador participar&aacute; de coletas de campo, observa&ccedil;&atilde;o e registro de esp&eacute;cies, al&eacute;m de an&aacute;lises em laborat&oacute;rio sobre germina&ccedil;&atilde;o, crescimento e adapta&ccedil;&atilde;o das plantas. O projeto contribui para estudos de conserva&ccedil;&atilde;o ambiental e elabora&ccedil;&atilde;o de estrat&eacute;gias sustent&aacute;veis para preserva&ccedil;&atilde;o da flora local.</p>', 'PROJETOPESQUISA', '2025-01-29', '2025-08-13', '', 36, 'Vivian');

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
(114, 23, 4),
(115, 23, 1),
(116, 23, 3),
(117, 23, 5),
(118, 25, 1),
(119, 26, 4),
(120, 26, 1),
(121, 26, 3),
(122, 26, 5);

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
(17, 'lucas', 'lucas@gmail.com', '740.528.379-91', '$2y$10$qrKXRUvw/gpPRRsudngtbOcJX/ifKrGcLHuYLW5wnNy3lVh8wjNta', 'PROFESSOR', '20223024000', NULL, NULL),
(33, 'julie', 'julie@gmail.com', '105.296.209-28', '$2y$10$vA9aJrsVzjL9IXQ76MbeqOJVGQDYHIGNp.I.pQa7M1RJZf4M9MtoO', 'ALUNO', '20223024000', 1, NULL),
(35, 'juliana', 'juliana@gmail.com', '079.150.660-64', '$2y$10$nHV0gCL7PW95AGd4ONpJLOJ4DF.PSCBBRYXxV5bQEiS41FCrLKl5K', 'ALUNO', '46541816516', 4, NULL),
(36, 'ana', 'ana@gmail.com', '106.660.100-30', '$2y$10$xjLtAZzLFaqkDmNPt7TBhuHghrcgehENwqrMAIX1fkxvLepbMNFSS', 'ALUNO', '2312', 3, NULL);

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
  ADD KEY `fk_notificacoes_usuarios1` (`idUsuarios`);

--
-- Índices de tabela `oportunidades`
--
ALTER TABLE `oportunidades`
  ADD PRIMARY KEY (`idOportunidades`);

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
  MODIFY `idInscricoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de tabela `oportunidades`
--
ALTER TABLE `oportunidades`
  MODIFY `idOportunidades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `oportunidade_curso`
--
ALTER TABLE `oportunidade_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  ADD CONSTRAINT `fk_notificacoes_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_usuarios_cursos1` FOREIGN KEY (`idCursos`) REFERENCES `cursos` (`idCursos`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/10/2025 às 21:30
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

--
-- Despejando dados para a tabela `inscricoes`
--

INSERT INTO `inscricoes` (`idInscricoes`, `documentosAnexo`, `feedbackProfessor`, `status`, `idOportunidades`, `idUsuarios`) VALUES
(20, '1759253988_atestadoIsabela.pdf', NULL, 'PENDENTE', 11, 33);

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
(9, 'Estágio no Parque Tecnológico Itaipu (PTI)', '<p>O Itaipu Parquetec, tamb&eacute;m conhecido como PTI, oferece a oportunidade de est&aacute;gio para estudantes que desejam integrar um ambiente de inova&ccedil;&atilde;o, pesquisa e desenvolvimento tecnol&oacute;gico.&nbsp;</p><p data-start=\"717\" data-end=\"1039\" id=\"isPasted\">Todas as vagas de est&aacute;gio (incluindo est&aacute;gios n&atilde;o-obrigat&oacute;rios) s&atilde;o divulgadas e gerenciadas por meio do <strong data-start=\"848\" data-end=\"871\">Portal do Candidato</strong> do Itaipu Parquetec, em parceria com o CIEE. &Eacute; necess&aacute;rio manter o cadastro atualizado no CIEE para acessar e concorrer &agrave;s vagas. <span data-state=\"closed\"><span data-testid=\"webpage-citation-pill\"><a href=\"https://candidato.itaipuparquetec.org.br/opportunities/internship.xhtml?utm_source=chatgpt.com\" target=\"_blank\" rel=\"noopener\" alt=\"https://candidato.itaipuparquetec.org.br/opportunities/internship.xhtml?utm_source=chatgpt.com\">candidato.itaipuparquetec.org.br</a></span></span><span data-state=\"closed\"><span data-testid=\"webpage-citation-pill\"><a href=\"https://www.pti.org.br/trabalheconosco?utm_source=chatgpt.com\" target=\"_blank\" rel=\"noopener\" alt=\"https://www.pti.org.br/trabalheconosco?utm_source=chatgpt.com\">Itaipu Parquetec</a></span></span></p><p data-start=\"1041\" data-end=\"1231\">Acesse o Portal do Candidato aqui: <strong data-start=\"1076\" data-end=\"1120\">[Portal do Candidato &ndash; Itaipu Parquetec]</strong>(<a data-start=\"1121\" data-end=\"1192\" rel=\"noopener\" target=\"_new\" href=\"https://candidato.itaipuparquetec.org.br/opportunities/internship.xhtml?utm_source=chatgpt.com\">https://candidato.itaipuparquetec.org.br/opportunities/internship.xhtml</a>)&nbsp;</p>', 'ESTAGIO', '2025-09-02', '2025-10-07', '', 1, ''),
(10, 'Teatro em Cena: Expressão, Cultura e Cidadania', '<p data-start=\"175\" data-end=\"512\" id=\"isPasted\"><strong data-start=\"175\" data-end=\"189\">Descri&ccedil;&atilde;o:</strong><br data-start=\"189\" data-end=\"192\">O projeto de extens&atilde;o <em data-start=\"214\" data-end=\"230\">Teatro em Cena</em> tem como objetivo promover a arte teatral como ferramenta de transforma&ccedil;&atilde;o social, cultural e educacional. A iniciativa busca oferecer oficinas de interpreta&ccedil;&atilde;o, express&atilde;o corporal, improvisa&ccedil;&atilde;o e montagem de pe&ccedil;as teatrais, abertas &agrave; comunidade acad&ecirc;mica e &agrave; popula&ccedil;&atilde;o em geral.</p><p data-start=\"880\" data-end=\"1072\">O projeto tamb&eacute;m prev&ecirc; apresenta&ccedil;&otilde;es p&uacute;blicas dos trabalhos desenvolvidos, democratizando o acesso ao teatro e incentivando a participa&ccedil;&atilde;o ativa da sociedade na valoriza&ccedil;&atilde;o da cultura local.</p>', 'PROJETOEXTENSAO', '2025-09-01', '2025-09-30', '', 12, ''),
(11, 'Tecnologias Digitais na Educação: Impactos e Possibilidades', '<p data-start=\"191\" data-end=\"451\" id=\"isPasted\">Este projeto de pesquisa tem como objetivo analisar os impactos do uso de tecnologias digitais no processo de ensino e aprendizagem, identificando desafios e oportunidades que surgem com a integra&ccedil;&atilde;o de recursos tecnol&oacute;gicos em sala de aula.</p><p data-start=\"943\" data-end=\"1172\">Espera-se que os resultados possam oferecer subs&iacute;dios para a ado&ccedil;&atilde;o mais consciente e eficaz das tecnologias digitais na educa&ccedil;&atilde;o, contribuindo para pol&iacute;ticas p&uacute;blicas, forma&ccedil;&atilde;o de professores e pr&aacute;ticas pedag&oacute;gicas inovadoras.</p>', 'PROJETOPESQUISA', '2025-09-01', '2025-10-11', '', 14, 'Jefferson Chaves');

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
(19, 9, 1),
(20, 9, 3),
(21, 10, 1),
(22, 10, 3),
(37, 11, 1);

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
(17, 'lucas', 'lucas@gmail.com', '740.528.379-91', '$2y$10$5JeNgmKoZyZQ4UuI/S/5V.vmGDwH6yM3kK.MYqt9xwTgABVx9k3MO', 'PROFESSOR', '20223024000', NULL, NULL),
(33, 'julie', 'julie@gmail.com', '105.296.209-28', '$2y$10$ijMwp1uwRHyYigg2Ml2YJ.B8kIDeVB8CuPzuw3Un0asUsPGEZgukS', 'ALUNO', '20223024000', 1, NULL);

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
  MODIFY `idInscricoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `oportunidades`
--
ALTER TABLE `oportunidades`
  MODIFY `idOportunidades` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `oportunidade_curso`
--
ALTER TABLE `oportunidade_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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

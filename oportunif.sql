CREATE TABLE IF NOT EXISTS `cursos` (
    `idCursos` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(45) NULL,
    PRIMARY KEY (`idCursos`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `idUsuarios` INT NOT NULL AUTO_INCREMENT,
    `nomeCompleto` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `cpf` VARCHAR(20) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `tipoUsuario` ENUM('ALUNO', 'PROFESSOR', 'ADMIN') NOT NULL,
    `matricula` VARCHAR(45),
    `idCursos` INT,
    `fotoPerfil` varchar(255) DEFAULT NULL
    PRIMARY KEY (`idUsuarios`),
    CONSTRAINT `fk_usuarios_cursos1` FOREIGN KEY (`idCursos`) REFERENCES `cursos` (`idCursos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `oportunidades` (
    `idOportunidades` INT NOT NULL,
    `titulo` VARCHAR(45) NULL,
    `descricao` VARCHAR(45) NULL,
    `tipoOportunidade` ENUM('ESTAGIO', 'PROJETOEXTENSAO', 'PROJETOPESQUISA') NOT NULL,
    `dataInicio` DATE NOT NULL,
    `dataFim` DATE NOT NULL,
    `documentoAnexo` VARCHAR(100) NULL,
    `idUsuarios` INT NOT NULL,
    `idCursos` INT NOT NULL,
    PRIMARY KEY (`idOportunidades`),
    CONSTRAINT `fk_oportunidades_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_oportunidades_cursos1` FOREIGN KEY (`idCursos`) REFERENCES `cursos` (`idCursos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `notificacoes` (
    `idNotificacoes` INT NOT NULL,
    `mensagem` VARCHAR(45) NOT NULL,
    `dataEnvio` DATE NOT NULL,
    `status` ENUM('ENVIADO', 'LIDO') NOT NULL,
    `idUsuarios` INT NOT NULL,
    PRIMARY KEY (`idNotificacoes`),
    CONSTRAINT `fk_notificacoes_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `inscricoes` (
    `idInscricoes` INT NOT NULL AUTO_INCREMENT,
    `documentosAnexo` VARCHAR(100),
    `feedbackProfessor` VARCHAR(45),
    `status` ENUM('PENDENTE', 'APROVADO', 'REPROVADO'),
    `idOportunidades` INT NOT NULL,
    `idUsuarios` INT NOT NULL,
    PRIMARY KEY (`idInscricoes`),
    CONSTRAINT `fk_inscricoes_oportunidades1` FOREIGN KEY (`idOportunidades`) REFERENCES `oportunidades` (`idOportunidades`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_inscricoes_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

/* Senha: senha123*/
INSERT INTO `usuarios` 
(`nomeCompleto`, `email`, `cpf`, `senha`, `tipoUsuario`) 
VALUES 
('Roberta Silva', 'robertasilva@gmail.com', '123.456.789-00', '$2y$10$ZGHJ8Qgqc4h3xDZu4dVXP.t4vLlz1bb7.NcbQ7ovILuWiacinA2Ku', 'ADMIN');

INSERT INTO cursos (nome) VALUES ('Técnico em Desenvolvimento de Sistemas (TDS)');

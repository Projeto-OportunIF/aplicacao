- -----------------------------------------------------
-- Table `cursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos` (
    `idCursos` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(45) NULL,
    PRIMARY KEY (`idCursos`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `usuarios` (
    `idUsuarios` INT NOT NULL AUTO_INCREMENT,
    `nomeCompleto` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL,
    `cpf` VARCHAR(20) NOT NULL,
    `senha` VARCHAR(100) NOT NULL,
    `tipo_usuario` VARCHAR(45) NOT NULL,
    `matricula` VARCHAR(45) NOT NULL,
    `idCursos` INT NOT NULL,
    PRIMARY KEY (`idUsuarios`),
    CONSTRAINT `fk_usuarios_cursos1` FOREIGN KEY (`idCursos`) REFERENCES `cursos` (`idCursos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `oportunidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `oportunidades` (
    `idOportunidades` INT NOT NULL,
    `titulo` VARCHAR(45) NULL,
    `descricao` VARCHAR(45) NULL,
    `tipoOportunidade` VARCHAR(45) NULL,
    `dataInicio` DATE NULL,
    `dataFim` DATE NULL,
    `documentoAnexo` VARCHAR(100) NULL,
    `idUsuarios` INT NOT NULL,
    `idCursos` INT NOT NULL,
    PRIMARY KEY (`idOportunidades`),
    CONSTRAINT `fk_oportunidades_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_oportunidades_cursos1` FOREIGN KEY (`idCursos`) REFERENCES `cursos` (`idCursos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `notificacoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `notificacoes` (
    `idNotificacoes` INT NOT NULL,
    `mensagem` VARCHAR(45) NOT NULL,
    `dataEnvio` DATE NOT NULL,
    `status` VARCHAR(45) NOT NULL,
    `idUsuarios` INT NOT NULL,
    PRIMARY KEY (`idNotificacoes`),
    CONSTRAINT `fk_notificacoes_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `inscricoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `inscricoes` (
    `idInscricoes` INT NOT NULL AUTO_INCREMENT,
    `documentosAnexo` VARCHAR(100) NOT NULL,
    `feedbackProfessor` VARCHAR(45) NOT NULL,
    `idOportunidades` INT NOT NULL,
    `idUsuarios` INT NOT NULL,
    PRIMARY KEY (`idInscricoes`),
    CONSTRAINT `fk_inscricoes_oportunidades1` FOREIGN KEY (`idOportunidades`) REFERENCES `oportunidades` (`idOportunidades`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_inscricoes_usuarios1` FOREIGN KEY (`idUsuarios`) REFERENCES `usuarios` (`idUsuarios`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB;
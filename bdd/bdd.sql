SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `GOD` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `GOD` ;

-- -----------------------------------------------------
-- Table `GOD`.`Estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Estados` (
  `id_estado` INT NOT NULL AUTO_INCREMENT,
  `resumen` TEXT NULL,
  `descripcion` LONGTEXT NULL,
  `votos_positivos` INT NULL,
  `votos_negativos` INT NULL,
  `entrada_en_vigor` DATETIME NULL,
  `caducidad` DATETIME NULL,
  PRIMARY KEY (`id_estado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Situaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Situaciones` (
  `id_situacion` INT NOT NULL,
  `problematica` INT NULL,
  PRIMARY KEY (`id_situacion`),
  CONSTRAINT `fk_Problema_Estados1`
    FOREIGN KEY (`id_situacion`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Las situaciones tienen causas y consecuencias y pueden ser p /* comment truncated */ /*roblemáticas o no. A partir de las cuales se generan propuestas.*/';


-- -----------------------------------------------------
-- Table `GOD`.`Objetivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Objetivos` (
  `id_objetivo` INT NOT NULL,
  `tiempo_estimado` INT NULL COMMENT 'Tiempo de trabajo necesario estimado para conseguir el objetivo. En función del tiempo estimado (y de otros factores) se determinará la factibilidad del objetivo.',
  PRIMARY KEY (`id_objetivo`),
  CONSTRAINT `fk_Objetivo_Estados`
    FOREIGN KEY (`id_objetivo`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Un objetivo es una descripción de un estado o una acción.';


-- -----------------------------------------------------
-- Table `GOD`.`Condiciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Condiciones` (
  `id_estado_condicionado` INT NOT NULL COMMENT 'Es el estado al que afecta la condición.',
  `id_estado_condicion` INT NOT NULL,
  PRIMARY KEY (`id_estado_condicionado`, `id_estado_condicion`),
  INDEX `fk_Estados_has_Estados_Estados2_idx` (`id_estado_condicion` ASC),
  INDEX `fk_Estados_has_Estados_Estados1_idx` (`id_estado_condicionado` ASC),
  CONSTRAINT `fk_Estados_has_Estados_Estados1`
    FOREIGN KEY (`id_estado_condicionado`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estados_has_Estados_Estados2`
    FOREIGN KEY (`id_estado_condicion`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Subobjetivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Subobjetivos` (
  `id_objetivo` INT NOT NULL,
  `id_subobjetivo` INT NOT NULL,
  PRIMARY KEY (`id_objetivo`, `id_subobjetivo`),
  INDEX `fk_Objetivo_has_Objetivo_Objetivo2_idx` (`id_subobjetivo` ASC),
  INDEX `fk_Objetivo_has_Objetivo_Objetivo1_idx` (`id_objetivo` ASC),
  CONSTRAINT `fk_Objetivo_has_Objetivo_Objetivo1`
    FOREIGN KEY (`id_objetivo`)
    REFERENCES `GOD`.`Objetivos` (`id_objetivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objetivo_has_Objetivo_Objetivo2`
    FOREIGN KEY (`id_subobjetivo`)
    REFERENCES `GOD`.`Objetivos` (`id_objetivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Los subobjetivos son el \"cómo\" de un objetivo y éste a su ve /* comment truncated */ /*z es su "para qué".*/';


-- -----------------------------------------------------
-- Table `GOD`.`Causas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Causas` (
  `id_causa` INT NOT NULL,
  `id_consecuencia` INT NOT NULL,
  PRIMARY KEY (`id_causa`, `id_consecuencia`),
  INDEX `fk_Problema_has_Problema_Problema2_idx` (`id_consecuencia` ASC),
  INDEX `fk_Problema_has_Problema_Problema1_idx` (`id_causa` ASC),
  CONSTRAINT `fk_Problema_has_Problema_Problema1`
    FOREIGN KEY (`id_causa`)
    REFERENCES `GOD`.`Situaciones` (`id_situacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Problema_has_Problema_Problema2`
    FOREIGN KEY (`id_consecuencia`)
    REFERENCES `GOD`.`Situaciones` (`id_situacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Propuestas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Propuestas` (
  `id_situacion` INT NOT NULL,
  `id_objetivo` INT NOT NULL,
  PRIMARY KEY (`id_situacion`, `id_objetivo`),
  INDEX `fk_Objetivo_has_Problema_Problema1_idx` (`id_objetivo` ASC),
  INDEX `fk_Objetivo_has_Problema_Objetivo1_idx` (`id_situacion` ASC),
  CONSTRAINT `fk_Objetivo_has_Problema_Objetivo1`
    FOREIGN KEY (`id_situacion`)
    REFERENCES `GOD`.`Objetivos` (`id_objetivo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Objetivo_has_Problema_Problema1`
    FOREIGN KEY (`id_objetivo`)
    REFERENCES `GOD`.`Situaciones` (`id_situacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Grupos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Grupos` (
  `id_grupo` INT NOT NULL,
  PRIMARY KEY (`id_grupo`),
  CONSTRAINT `fk_Grupos_Estados1`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Grupos_has_Estados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Grupos_has_Estados` (
  `id_grupo` INT NOT NULL,
  `id_estado` INT NOT NULL,
  PRIMARY KEY (`id_grupo`, `id_estado`),
  INDEX `fk_Grupos_has_Estados_Estados1_idx` (`id_estado` ASC),
  INDEX `fk_Grupos_has_Estados_Grupos1_idx` (`id_grupo` ASC),
  CONSTRAINT `fk_Grupos_has_Estados_Grupos1`
    FOREIGN KEY (`id_grupo`)
    REFERENCES `GOD`.`Grupos` (`id_grupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Grupos_has_Estados_Estados1`
    FOREIGN KEY (`id_estado`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(200) NULL,
  `pass` VARCHAR(200) NULL,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Votaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Votaciones` (
  `id_usuario` INT NOT NULL,
  `id_estado` INT NOT NULL,
  `inclinacion` INT NULL,
  `representatividad` DECIMAL(10) NULL COMMENT 'Indica si la votación es representativa y en qué medida. Quizá baste con poner el porcentaje de votos que representa de los que no se han pronunciado.',
  PRIMARY KEY (`id_usuario`, `id_estado`),
  INDEX `fk_Usuarios_has_Estados_Estados1_idx` (`id_estado` ASC),
  INDEX `fk_Usuarios_has_Estados_Usuarios1_idx` (`id_usuario` ASC),
  CONSTRAINT `fk_Usuarios_has_Estados_Usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `GOD`.`Usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuarios_has_Estados_Estados1`
    FOREIGN KEY (`id_estado`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `GOD`.`Tipos_notificacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Tipos_notificacion` (
  `id_tipo` INT NOT NULL AUTO_INCREMENT,
  `nombre` TEXT NULL,
  PRIMARY KEY (`id_tipo`))
ENGINE = InnoDB
COMMENT = 'Define y describe los tipos de notificación que pueden darse /* comment truncated */ /*. En principio: opinar, evaluar, */';


-- -----------------------------------------------------
-- Table `GOD`.`Notificaciones`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `GOD`.`Notificaciones` (
  `id_notificacion` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL COMMENT 'Usuario al que va dirigida.',
  `id_estado` INT NOT NULL COMMENT 'Estado con el que está relacionada la notificación.',
  `id_tipo` INT NOT NULL,
  PRIMARY KEY (`id_notificacion`),
  INDEX `fk_Notificaciones_Usuarios1_idx` (`id_usuario` ASC),
  INDEX `fk_Notificaciones_Estados1_idx` (`id_estado` ASC),
  INDEX `fk_Notificaciones_Tipos_notificacion1_idx` (`id_tipo` ASC),
  CONSTRAINT `fk_Notificaciones_Usuarios1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `GOD`.`Usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Notificaciones_Estados1`
    FOREIGN KEY (`id_estado`)
    REFERENCES `GOD`.`Estados` (`id_estado`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Notificaciones_Tipos_notificacion1`
    FOREIGN KEY (`id_tipo`)
    REFERENCES `GOD`.`Tipos_notificacion` (`id_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Las notificaciones las genera el sistema para uno o varios u /* comment truncated */ /*suarios. Se le mostrarán en el momento en que vuelva a iniciar sesión.*/';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


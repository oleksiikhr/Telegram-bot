-- MySQL Script generated by MySQL Workbench
-- Fri Jun 23 16:46:19 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema tlg
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema tlg
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tlg` DEFAULT CHARACTER SET utf8 ;
USE `tlg` ;

-- -----------------------------------------------------
-- Table `tlg`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tlg`.`Users` (
  `tlg_id` BIGINT(20) NOT NULL,
  `name` VARCHAR(25) NOT NULL,
  `kills` INT NOT NULL DEFAULT 0,
  `rating` INT NOT NULL DEFAULT 0,
  `method` VARCHAR(100) NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE INDEX `tlg_id_UNIQUE` (`tlg_id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  PRIMARY KEY (`tlg_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tlg`.`Games`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tlg`.`Games` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `game` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tlg`.`Sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tlg`.`Sessions` (
  `Users_tlg_id` BIGINT(20) NOT NULL,
  `Games_id` INT NOT NULL,
  `pos_x` TINYINT NOT NULL,
  `pos_y` TINYINT NOT NULL,
  `angle` TINYINT NOT NULL,
  `health` TINYINT NOT NULL DEFAULT 100,
  `kills` TINYINT NOT NULL DEFAULT 0,
  `team` TINYINT NOT NULL,
  `rnd` TINYINT NOT NULL,
  `action` VARCHAR(255) NULL,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `fk_Session_Users1_idx` (`Users_tlg_id` ASC),
  INDEX `fk_Session_Games1_idx` (`Games_id` ASC),
  PRIMARY KEY (`Users_tlg_id`),
  CONSTRAINT `fk_Session_Users1`
    FOREIGN KEY (`Users_tlg_id`)
    REFERENCES `tlg`.`Users` (`tlg_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Session_Games1`
    FOREIGN KEY (`Games_id`)
    REFERENCES `tlg`.`Games` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `tlg`.`Users`
-- -----------------------------------------------------
START TRANSACTION;
USE `tlg`;
INSERT INTO `tlg`.`Users` (`tlg_id`, `name`, `kills`, `rating`, `method`, `create_time`, `update_time`) VALUES (182767170, 'Alexey', DEFAULT, DEFAULT, NULL, '2017-06-21 11:59:40', '2017-06-21 11:59:40');
INSERT INTO `tlg`.`Users` (`tlg_id`, `name`, `kills`, `rating`, `method`, `create_time`, `update_time`) VALUES (123, 'Bot1', DEFAULT, DEFAULT, 'Team Deathmatch', '2017-06-21 11:59:40', '2017-06-21 11:59:40');
INSERT INTO `tlg`.`Users` (`tlg_id`, `name`, `kills`, `rating`, `method`, `create_time`, `update_time`) VALUES (1234, 'Bot2', DEFAULT, DEFAULT, 'Team Deathmatch', '2017-06-21 11:59:40', '2017-06-21 11:59:40');
INSERT INTO `tlg`.`Users` (`tlg_id`, `name`, `kills`, `rating`, `method`, `create_time`, `update_time`) VALUES (12345, 'Bot3', DEFAULT, DEFAULT, 'Team Deathmatch', '2017-06-21 11:59:40', '2017-06-21 11:59:40');

COMMIT;


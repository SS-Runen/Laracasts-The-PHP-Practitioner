# Laracasts-The-PHP-Practitioner
 
## SQL script to create database and tables in default form with default data:

-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema wt_perfmon
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wt_perfmon` DEFAULT CHARACTER SET utf8 ;
USE `wt_perfmon` ;

-- -----------------------------------------------------
-- Table `wt_perfmon`.`tbl_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wt_perfmon`.`tbl_users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(250) NOT NULL,
  `usertype` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;

INSERT INTO `wt_perfmon`.`tbl_users` (`user_id`, `username`, `password`, `usertype`) VALUES ('2', 'Test', 'Test', 'user');
INSERT INTO `wt_perfmon`.`tbl_users` (`user_id`, `username`, `password`, `usertype`) VALUES ('0', 'J_Rives', 'vVYb9mvF', 'super-admin');
INSERT INTO `wt_perfmon`.`tbl_users` (`user_id`, `username`, `password`, `usertype`) VALUES ('1', 'M_Rives', 'max', 'user');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


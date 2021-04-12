# Laracasts: The PHP Practitioner
 
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

## Copy of Notes During Development
Notes taken directly from Notes.txt detailing problems or important ideas as they are found.

2021-03-19

Proofs of concept successful.
    Database model created on MySQL Workbench.
    Model was forward engineered onto local MySQL and onto AWS RDS MySQL instance.
    Hompage index.php took data from local and AWS MySQL instances and displayed through PDO.

2021-03-22
    Test of hand-made classes unsuccessfull. Database connection is good and there is no syntax error. Not resolved:
    Valid PDOStatement was being created successfully but returning False when PDOStatement->fetch() was called.
    Suspicious:
    Lines 32, 40, and 44 in DBManager tirggered Notice: Only variables should be passed by reference.

2021-03-24
    Hand-made classes working.
    - Modified Configuration file. Variables declared outside of a class are not accessible to it or its methods/funcitons. Had to modify Configuration.php.
    - Result of PDOStatement->fetch() were false because of missing PDOStatement->execute(). Tested using verfied correct SQL statement. The fetch() method will only succeed if execute has previously been called. It implies that the PDOStatement instance object is modified after a call to execute, allowing fetch to work.
2021-03-25
    Result of PDOStatement->execute() is traversable. When traversing a PDOStatement object element-wise after a successful return of results, each element is returned as an associative array by default.
    Unable to create table for routes.
    Hand-made functions working for unknown reason: removing PDOStatement->bindParam() and using the literal variables instead caused user list to be displayed properly using hand-made DBManager.
2021-03-26
    - Partially verified that DBManager and Router are working. To clarify, errors on previous day were ocurring even when database, table and data were created. This was becuase when DBManager::returnCurrentConnection was called, there was no connection created yet. Solved by adding self::prepareToQuery() in definition of returnCurrentConnection.
    - Testing by hard-coding URI as input into the Router::returnPath function succeeded. Database was also being created automatically and bootstrap file was being used as a "preloader" in index.php.
    - Problem not solved: when URI aside from plain "host/ProjectName/" was typed into address bar, it was "Not Found". Presumed to be issue with XAMPP configuration not being set to direct all traffic, i.e. all URIs, to index.php.
2021-03-29
    - Removed route_id from tbl_routes to prevent multiple registering of the same route. URI is now used as primary key since it should be unique anyway.
    - From StackOverflow answer. Changed php.ini file to automatically load the PHP extension: "extension=pdo_mysql". Searched for error message thrown by PHP server. It ran a toy PHP script successfully (displayed "Hello World!") but errored on own project.
    - Routing works now. Can now modify project directly in GitHub folder. Had to remove array_slice on URI in index.php. In XAMPP, URI from $_SERVER['REQUEST_URI'] included "/Laracasts-The.../". When running `php -S localhost:4005`, URI is plain/project's containing folder is omitted.
2021-03-30
    - Azure Depoyment Center service did not offer option for PHP in runtime stack. Cancelling trial.
    - Rudimentary/primitive routing to special pages/controllers working.
    - ISSUE: When using Router::setRoute(), the order in which the parameters are given in the call also changes the database column they are inserted into. Named parameters were used.

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

2021-04-01
    - Using method sprintf() to determine order in which function parameters are inserted into string does not work. Did not solve problem where order of parameters in function declaration was being followed instead of order in which they were inserted in function declaration body.
    - To allow proper table name to be passed to form controller, an input field with the following properties was added to registration.view.php:
    `<input type="hidden" name="table" value="tbl_users" readonly>`
    - Test run with registration form is done. Flow:
    registration.controller.php -> registration.view.php -> form.controller.php -> index.view.php
    At the moment, registration.controller.php does nothing except load the view. Attempts to set a static variable in registration.controller.php using `FormHandler::$var` failed due to the variable being inaccessible. Removing the variable type declaration, adding a __constructor then using another method with `new self()` to set the variable, and simply using a method that set the static variable/property using `self::$var` failed. Error message:

    Fatal error: Uncaught Error: Typed static property FormHandler::$target_table must not be accessed before initialization in C:\Users\max\Documents\GitHub\Laracasts-The-PHP-Practitioner\Core\FormHandler.php:9 Stack trace: #0 C:\Users\max\Documents\GitHub\Laracasts-The-PHP-Practitioner\Controllers\form.controller.php(16): FormHandler::postData() #1 C:\Users\max\Documents\GitHub\Laracasts-The-PHP-Practitioner\index.php(21): require('...') #2 {main} thrown in C:\Users\max\Documents\GitHub\Laracasts-The-PHP-Practitioner\Core\FormHandler.php on line 9

2021-04-03
    - Command `composer install` will install itself an load dependencies declared in `/composer`.json. It will create a pre-set folder/directory structure and give an autoload.php file which should be called in order for the dependencies to actually load.
    - Command `composer dump-autoload` must be run if a new class/file is created in your project. This command must also be run if modifications have been made to any class' source.
    - For now, the class `App` will serve as a dependency injection container.

2021-04-08
    - Unable to refactor code to allow namespaces. Error on scripts that do not contain classes, including the "landing page" index.php. Despite the user keyword being supplied with the right namesapce, class still not found.

2021-04-09
    - Rolling back scope: omitted requirement to use namesapces. Refactored to use controller classes instead. Structure: Two controllers, InputController for user data upload or form submissions/actions. RequestController for all GET requests. One function to one URI. Used the `mixed` pseudo-type to allow an optional parameter `data` for all functions for error message.
    - Used PHP syntax where if item after `new` was a string, a class of that name would be created. if the accessors `::` or `->` were followed by a string, a function of that name would also be called using the object before the accessors.
2021-04-10
    - Successful refactor into using namespaces. The error was that the namespaces did not have one top-level namespace. Setting the namespaces as `Core\Database` and `AppSpecific\Controllers` meant that the controllers and the database helper class were prevented from communicating with each other. There has to be an identical top-level namespace for them to use each other. Correct namespaces are `App\Core\Database` and `App\AppSpecific\Controllers`. The keyword `App` is arbitrary.
    - Namespaces are arbitrary and do not need to mimic folder structure to work. Namespaces mimicing folder structure is just a convention.

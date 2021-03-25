<?php

class Router {    

    public function __construct()
    {
        $this->makeURI_Table();
    }

    public static function makeURI_Table () {
        //define("db_name", "wt_perfmon");
        $db_name = "wt_perfmon";
        $routestbl_name="tbl_routes";
        $query = <<<STR
        CREATE TABLE IF NOT EXISTS `$db_name`.`$routestbl_name` (
            `route_id` INT NOT NULL AUTO_INCREMENT,
            `uri` VARCHAR(256) NOT NULL,
            `path` VARCHAR(1024) NOT NULL,
            PRIMARY KEY (`idtbl_routes`));          
        STR;
        $rslt = new PDO(
            "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
            "admin",
            "vVYb9mvF",
            []
        );

        DBManager::setActiveConnection($rslt);

        $rslt->exec(
            $statement=$query
        );        

        if ($rslt == false) {
            throw new Exception(
                $message="Failed to attempt creation of routes databse.");
        }
    }

    public static function setRoute (
        $uri,
        $view_path
    ) {        
        $datetime = date(
            $format="Y-m-d H:i:s"    
        );
        $str_sql = <<<STR
        INSERT INTO
        `wt_perfmon`.`tbl_users`
        (`route_id`, `uri`, `path`)
        VALUES
        ('$datetime', '$uri', '$view_path') as new_values
        ON DUPLICATE KEY UPDATE
        uri=new_values.uri,
        path=new_values.path;
        STR;

        // $pdo = DBManager::returnCurrentConnection();
        // $pdo->exec(
        //     $command=$str_sql
        // );

        DBManager::insert(
            // $table="`wt_perfmon`.`tbl_routes`",
            $table="tbl_routes",
            $columns="(`route_id`, `uri`, `path`)",
            $values="('$datetime', '$uri', '$view_path')"
        );
    }

    public static function returnPath (
        $uri
    ) {
        $result = DBManager::query(
            $tbl="`wt_perfmon`.`tbl_routes`",
            $columns="path",
            $constraints="WHERE uri = $uri"
        );
        if ($result == false) {
            throw new Exception("URI not found in database.");
        }
        else {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
    }
}

?>
<?php

class Configuration {

    public static $db_defaults;
    private static $routesdb_name = "wt_perfmon";

    public static function returnDefaultConn()
    {
        self::$db_defaults = [
            "dsn" => "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
            "username" => "admin",
            "password" => "vVYb9mvF",
            "options" => []
        ];

        // self::$db_defaults = [
        //     "dsn" => "mysql:host=127.0.0.1;dbname=wt_perfmon;",
        //     "username" => "root",
        //     "password" => "root",
        //     "options" => []
        // ];

        return self::$db_defaults;
    }
}
?>
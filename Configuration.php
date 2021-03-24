<?php

class Configuration {

    public static $db_defaults;

    public static function returnDefaultConn()
    {
        self::$db_defaults = [
            "dsn" => "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
            "username" => "admin",
            "password" => "vVYb9mvF",
            "options" => []
        ];

        return self::$db_defaults;
    }
}
?>
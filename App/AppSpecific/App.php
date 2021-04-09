<?php

// namespace App\AppSpecific;

// use Exception;

class App {
    protected static array $dependencies = [
        "default_database" => [
            "dsn" => "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
            "username" => "admin",
            "password" => "vVYb9mvF",
            "options" => []
        ]
    ];

    public static function set ($alias, $dependency) {
        self::$dependencies[$alias] = $dependency;
    }

    public static function get (String $label) {
        if (array_key_exists(
            $key=$label,
            $search=self::$dependencies)) {
                return self::$dependencies[$label];
        }
        else {
            throw new Exception($message="No such dependency key/label found.");
        }
    }
}

?>
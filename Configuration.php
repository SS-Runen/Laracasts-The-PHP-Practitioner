<?php

class Configuration {
    protected static $default_connection;
    private static String $default_dsn ="mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;";
    private static String $default_uname = "admin";
    private static String $default_pass = "vVYb9mvF";
    private static array $default_options = [];

    public static function setDefaultConnection (
        String $dsn_string=null,
        String $db_username=null,
        String $password=null,
        array $options_array=[]
    ) {
        if (isset($dsn_string) & isset($db_username) & isset($password)){
            self::$default_connection = new PDO(
                $dsn=$dsn_string,
                $username=$db_username,
                $passwd=$password,
                $options=$options_array
            );            
        }
        else {
            self::$default_connection = new PDO(
                $dsn=self::$default_dsn,
                $username=self::$default_uname,
                $passwd=self::$default_pass,
                $options=self::$default_options
            );
            self::$default_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }   

    public static function returnDefaultConnection() {
        if (is_null(self::$default_connection)) {
            self::setDefaultConnection();
            return self::$default_connection;
        }
        else{ return self::$default_connection; }
    }

}

?>
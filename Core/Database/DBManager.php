<?php

class DBManager {

    private static $connection_in_use;
    private static $default_connection;
    private static $db_defaults;

    public static function makeConnection (
        $new_dsn,
        $new_username,
        $new_pass,
        $new_options = []
    ) {
        $conn = new PDO(
            $dsn=$new_dsn,
            $username=$new_username,
            $passwd=$new_pass,
            $options=$new_options
        );
        return $conn;
    }

    private static function setDefaultConnection (
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
            $db_defaults = Configuration::returnDefaultConn();
            self::$default_connection = new PDO(
                $dsn=$db_defaults["dsn"],
                $username=$db_defaults["username"],
                $passwd=$db_defaults["password"],
                $options=$db_defaults["options"]
            );
            self::$default_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function setActiveConnection (
        $DBConnection=null,
        String $dsn_string=null,
        String $db_username=null,
        String $password=null,
        array $options_array=[]
        ) {
            if (is_a($DBConnection, "PDO")) {
                self::$connection_in_use = $DBConnection;
            }
            else if (isset($dsn_string) & isset($db_username) & isset($password)) {
                $conn = self::makeConnection(
                        $dsn_string,
                        $db_username,
                        $password,
                        $options_array
                );
                self::setActiveConnection($conn);
            }
            else {
                throw new Exception($message="Given parameter is not a PDO.");
            }
        }

    public static function returnCurrentConnection () {
        return self::$connection_in_use;
    }

    private static function prepareToQuery () {
        if (is_null(self::$connection_in_use) || (!isset(self::$connection_in_use))) {
            self::setDefaultConnection();
            self::setActiveConnection(self::$default_connection);
        }
    }

    public static function query(
        String $tbl=null,
        String $columns=null,
        String $constraints=""        
    ) {
        self::prepareToQuery();

        $pdo_stmt = self::$connection_in_use->prepare(
            //$statement="SELECT :cols FROM :tbl :constraints ;"
            //$statement="SELECT * FROM tbl_users;"
            $statement="SELECT $columns FROM $tbl $constraints"
        );
        if (!is_a($pdo_stmt, "PDOStatement")) {
            $actual_type = gettype($pdo_stmt);
            $notPDO_exception = new Exception(
                $message="Current connection in use is not a PDO.\nType: `$actual_type`");
            throw $notPDO_exception;
        }

        // $pdo_stmt->bindParam(
        //     $paramter=":tbl",
        //     $variable=$tbl,
        //     $data_type=PDO::PARAM_STR
        // );

        // $pdo_stmt->bindParam(
        //     $parameter=":cols",
        //     $variable=$columns,
        //     $data_type=PDO::PARAM_STR
        // );

        // $pdo_stmt->bindParam(
        //     $parameter=":constraints",
        //     $variable=$constraints,
        //     $data_type=PDO::PARAM_STR
        // );

        $pdo_stmt->execute();
        if ($pdo_stmt == false) {
            throw new Exception(
                $message="Query failed to execute. PDOStatement->execute() returned false."
            );
        }
        
        return $pdo_stmt;
    }

    public static function insert(
        String $source,
        String $columns,
        String $values,
        array $options=[]
    ) {
        self::prepareToQuery();
        $sql_string = "INSERT INTO $source $columns VALUES $values;";

        $pdo_stmt = self::$connection_in_use->prepare(
            $statement=$sql_string,
            $driver_options=$options
        );

        $pdo_stmt->execute();

        if ($pdo_stmt == false) {
            throw new Exception (
                $message="Failed to insert into database. Query string:\n$sql_string"
            );
        }
        return $pdo_stmt;
    }

}

?>
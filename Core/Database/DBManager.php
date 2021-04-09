<?php

// namespace Core\Database;

// use PDO;
// use Exception;
// use App\AppSpecific\App;

class DBManager {

    private static $connection_in_use;
    private static $default_connection;
    private static $db_defaults;

    public static function log_query (String $sql_string) {
        $sql_query = "INSERT INTO `wt_perfmon`.`tbl_queries` VALUES (:sql_string);";
        $pdo = self::returnCurrentConnection();
        $stmt = $pdo->prepare($sql_query);
        $stmt->bindParam(':sql_string', $sql_string);
        $stmt->execute();
    }

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
            $db_defaults = App::get($label="default_database");
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
        self::prepareToQuery();
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
        $query_string="SELECT $columns FROM $tbl $constraints";

        $pdo_stmt = self::$connection_in_use->prepare(
            //$statement="SELECT :cols FROM :tbl :constraints ;"
            $statement=$query_string
        );
        if (!is_a($pdo_stmt, "PDOStatement")) {
            $actual_type = gettype($pdo_stmt);
            $notPDO_exception = new Exception(
                $message="Current connection in use is not a PDO.\nType: `$actual_type`");
            throw $notPDO_exception;
        }

        $failure_message = <<<STR
        Query failed to execute. PDOStatement->execute() returned false on:\n
        $query_string
        STR;

        $pdo_stmt->execute();
        if ($pdo_stmt == false) {
            throw new Exception(
                $message=$failure_message
            );
        }
        
        return $pdo_stmt;
    }

    public static function insert(
        String $target,
        String $columns="",
        String $values,
        // String $columns="",
        String $constraints="",
        array $options=[],
        bool $log_query=false
    ) {
        self::prepareToQuery();
        $sql_string = sprintf(
            $format="INSERT INTO %s %s VALUES %s %s;",
            $args=$target, $columns, $values, $constraints
        );

        $pdo_stmt = self::$connection_in_use->prepare(
            $statement=$sql_string,
            $driver_options=$options
        );

        try {
            $pdo_stmt->execute();
        } catch (Exception $e) {
            throw new Exception (
                $message="Failed to insert into database. Query string:\n$sql_string\nError:\n$e"
            );
        }

        if ($log_query) { self::log_query($sql_string); }
        return $pdo_stmt;
    }

}

?>
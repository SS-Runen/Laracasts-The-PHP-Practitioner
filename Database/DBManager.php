<?php
require "./Configuration.php";

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

    public static function setActiveConn ($DBConnection)
    {
        if (is_a($DBConnection, "PDO")) {
            self::$connection_in_use = $DBConnection;
        }
        else {
            throw new Exception($message="Given parameter is not a PDO.");
        }
    }

    public static function query(
        String $tbl=null,
        String $columns=null,
        String $constraints=null,
        int $row_limit = 256,
        int $fetch_style_int = PDO::FETCH_ASSOC //Also 2.
    ) {
        if (is_null(self::$connection_in_use)) {
            self::setDefaultConnection();
            self::$connection_in_use = self::$default_connection;
        }

        $pdo_stmt = self::$connection_in_use->prepare(
            // $statement="SELECT :cols FROM :tbl :constraints"
            $statement="SELECT * FROM tbl_users;"
        );
        if (!is_a($pdo_stmt, "PDOStatement")) {
            $actual_type = gettype($pdo_stmt);
            $notPDO_exception = new Exception(
                $message="Current connection in use is not a PDO.\nType: `$actual_type`");
            throw $notPDO_exception;
        }

        $pdo_stmt->bindParam(
            $paramter=":tbl",
            $variable=$tbl,
            $data_type=PDO::PARAM_STR
        );

        $pdo_stmt->bindParam(
            $parameter=":cols",
            $variable=$columns,
            $data_type=PDO::PARAM_STR
        );

        $pdo_stmt->bindParam(
            $parameter=":constraints",
            $variable=$constraints,
            $data_type=PDO::PARAM_STR
        );

        $pdo_stmt->execute();

        try{
            return $pdo_stmt->fetchAll(
                $fetch_style=$fetch_style_int
            );
        } catch (Exception $e) {            
            die("<b>Exception</b> ocurred:\n$e");
        }
    }

}

?>
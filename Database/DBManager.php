<?php
require "./Configuration.php";

class DBManager {

    protected static $current_connection;

    public static function makeConnection (
        $dsn, $uname, $pass, $options
    ) {
        return new PDO($dsn, $uname, $pass, $options);
    }

    public static function query(
        String $tbl=null,
        String $columns=null,
        String $constraints=null,
        int $row_limit = 256,
        int $fetch_style_int = PDO::FETCH_ASSOC //Also 2.
    ) {
        if (is_null(self::$current_connection)) {
            $conn = Configuration::returnDefaultConnection();
            self::$current_connection = $conn;
        }

        $pdo_stmt = self::$current_connection->prepare(
            $statement="SELECT :cols FROM :tbl :constraints"
        );

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

        try{
            return $pdo_stmt->fetch(
                $fetch_style=$fetch_style_int
            );
        } catch (PDOException $e) {
            echo "A <b>PDOException</b> type of error ocuured:\n$e";
            return false;        
        }
        return false;
    }

}

?>
<?php

namespace Core\Routing;

use App\Controllers\ViewController;
use Core\Database\DBManager;
use Exception;
use PDO;

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
            `uri` VARCHAR(256) NOT NULL,
            `path` VARCHAR(1024) NOT NULL,
            `request_type` VARCHAR(12) NOT NULL,
            PRIMARY KEY (`uri`));          
        STR;

        $rslt=DBManager::returnCurrentConnection();
        if (!is_a($rslt, "PDO")) {
            $actual_return = gettype($rslt);
            throw new Exception("Failed to get active database connection. Got a $actual_return");
        }

        $rslt->exec(
            $statement=$query
        );

        if ($rslt == false) {
            throw new Exception(
                $message="Failed to attempt creation of routes databse.");
        }
    }

    public static function setRoute (
        String $uri,
        String $filepath,
        String $request_type="GET"
    ) {

        DBManager::insert(
            $target="`wt_perfmon`.`tbl_routes`",
            $columns="(`uri`, `path`, `request_type`)",
            $values="('$uri', '$filepath', '$request_type')",
            $constraints="AS new_route
            ON DUPLICATE KEY UPDATE
              path=new_route.path,
              request_type=new_route.request_type;"
        );
    }

    public static function returnPath (
        String $uri,
        String $request_type="GET"
    ) {
        $result = DBManager::query(
            $tbl="`wt_perfmon`.`tbl_routes`",
            $columns="path",
            $constraints="WHERE uri = '$uri' AND request_type='$request_type'"
        );
        $error_message = <<<STR
        "PDO returned `false` for the parameters of DBManagement::query.\n
        Target=$tbl,\n
        Columns=$columns,\n
        Constraints=$constraints
        [END]
        STR;

        return $result->fetch(PDO::FETCH_ASSOC)["path"];
    }

    public static function callController(
        String $uri,
        String $request_type="GET"
    ) {
        return (new ViewController)->$uri();
    }

    public static function getURI () {
        $plain_uri = trim(
            $str=parse_url(
                $url=$_SERVER["REQUEST_URI"],
                $component=PHP_URL_PATH
            ),
            $charlist='/'
        );
        
        return $plain_uri;
    }

    public static function getReqeustType () {
        $req_type = $_SERVER["REQUEST_METHOD"];
        return $req_type;
    }
}

?>
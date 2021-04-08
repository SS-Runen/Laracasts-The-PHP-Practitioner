<?php

namespace App\Controllers;

use Core\Routing\Router;
use Core\Database\DBManager;
use PDO;
use Exception;
use PDOException;

class ViewController{

    public function index() {

        $pdo = null;
        try {
            /*
            PHP class definition:
            public __construct ( string $dsn , string $username = ? , string $passwd = ? , array $options = ? )
            */
            // $pdo = new PDO(
            //     $dsn = "mysql:host=127.0.0.1;dbname=wt_perfmon;",
            //     $username = "root",
            //     $passwd = ""
            // ); #Note; For MySQL local XAMPP
            
            // $pdo = new PDO(
            //     $dsn = "mysql:host=127.0.0.1;dbname=wt_perfmon;",
            //     $username = "root",
            //     $passwd = "root"
            // ); #Note: For MySQL local 8.0.2
            
            $pdo = new PDO(
                $dsn = "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
                $username = "admin",
                $passwd = "vVYb9mvF"
            );
        
        } catch (PDOException $e) {    
            echo "<pre>"."Could not connect to database. Error:\n$e"."</pre>";
        }

        $str_sql = "SELECT * FROM tbl_users";
        $pdostmt_temp = $pdo->prepare($str_sql);
        $pdostmt_temp->execute();

        $userlist = $pdostmt_temp->fetchAll(PDO::FETCH_OBJ);

        # Block is for testing using local instance of MySQL.
        # Comment/uncomment DBManager::setActiveConnection to test.
        // $pdo_local = new PDO(
        //     $dsn = "mysql:host=127.0.0.1;dbname=wt_perfmon;",
        //     $username = "root",
        //     $passwd = "root"
        // );
        // DBManager::setActiveConnection($pdo_local);
        
        #To test hand-made function meant to return uselist as associative array like successfull hardcode.
        $pdostmt_users = DBManager::query(
            $tbl="tbl_users",
            $columns="*"
        );

        # Require corresponding view file, in this case the view of homepage.
        require_once "Public/Views/index.view.php";
    }

}

?>
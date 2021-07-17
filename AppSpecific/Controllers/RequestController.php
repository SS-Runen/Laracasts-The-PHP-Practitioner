<?php

namespace App\AppSpecific\Controllers;

// use Core\Routing\Router;
use App\Core\Database\DBManager;
use PDO, Exception, PDOException;

class RequestController{

    public static function index($data) {

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
            
            $pdo = new PDO(
                $dsn = "mysql:host=127.0.0.1;dbname=wt_perfmon;",
                $username = "root",
                $passwd = "root"
            ); #Note: For MySQL local 8.0.2
            
            // $pdo = new PDO(
            //     $dsn = "mysql:host=db-wtperfmon.chvhk2xcrgnq.ap-southeast-1.rds.amazonaws.com;dbname=wt_perfmon;",
            //     $username = "admin",
            //     $passwd = "vVYb9mvF"
            // );
        
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

    public static function about ($data) {
        require "./Public/Views/about.view.php";
    }

    public static function sitemap ($data) {
        $pdostmt_sitepages = DBManager::query(
            $tbl="tbl_routes",
            $columns="uri"
        );
        
        require "./Public/Views/sitepages.view.php";
    }

    public static function registrationForm () {
        require "./Public/Views/registration.view.php";
    }

    public static function functionNotFound ($data) {
        echo "<pre><br><h2>Data for that request/operation not found.</h2><br>";
        echo "<h3>".var_dump($data)."</h3></pre>";        
        require "./Public/Views/resource_not_found.view.php";
    }

}

?>
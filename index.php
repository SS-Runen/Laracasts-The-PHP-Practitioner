<?php

try {
    /*
    PHP class definition:
    public __construct ( string $dsn , string $username = ? , string $passwd = ? , array $options = ? )
    */
    $pdo = new PDO(
        $dsn = "127.0.0.1",
        $username = "root",
        $passwd = "root",
        $options = []
    );
} catch (PDOException $e) {    
    echo "<pre>"."Could not connect to database. Error:\n$e"."</pre>";
}

$str_sql = "SELECT * FROM tbl_users";
$pdostmt_temp = $pdo->prepare($str_sql);
$pdostmt_temp->execute();

$userlist = $pdostmt_temp->fetchAll(PDO::FETCH_OBJ);

#Require Homepage view file.
require "index.view.php";

?>
<?php

use App\Core\Database\DBManager;

class InputController {

    public static function registerUser (
        $columns="",
        $values=""
    ) {
        echo "<br><h3>SERVER:</h3>";
        var_dump($_SERVER);
        echo "<br><h3>POST:</h3>";
        var_dump($_POST);
        echo "<br><h3>GET:</h3>";
        var_dump($_GET);

        require_once "./AppSpecific/FormHandler.php";

        $fieldnames = implode($glue=',', $pieces=array_keys($_POST));
        $contents = array_values($_POST);

        $single_qouted = [];
        foreach ($contents as $field) {
            array_push($single_qouted, ("'".$field."'"));
        }
        $content_string = implode($glue=',', $pieces=$single_qouted);

        if (count(array_keys($_POST)) > 0 & count(array_values($_POST)) > 0)
        {
            FormHandler::registerUser(
                $columns='('.$fieldnames.')',
                $values='('.$content_string.')'
            );
        }

        header("Location: /");

        DBManager::insert(
            $target="`wt_perfmon`.`tbl_users`",
            $columns=$columns,
            $values=$values
        );
    }

    public static function functionNotFound (mixed $data) {
        echo "<pre><br><h2>Couldn't upload that data.<br>";
        echo "</h2><h3>".var_dump($data)."</h3></pre>";      
        require "./Public/Views/resource_not_found.view.php";
    }
}
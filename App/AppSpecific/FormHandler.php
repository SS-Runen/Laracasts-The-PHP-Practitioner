<?php

namespace App\AppSpecific;

use Core\Database\DBManager;

class FormHandler {

    public static function registerUser (
        $columns="",
        $values=""
    ) {
        DBManager::insert(
            $target="`wt_perfmon`.`tbl_users`",
            $columns=$columns,
            $values=$values
        );
    }

}
?>
<?php

?>

<html>
    <h1>Welcome Home</h1>
    <table>
        <?php
        foreach ($userlist as $userlist_row) {
            echo "<tr><td>$userlist_row->user_id</td><td>$userlist_row->username</td></tr>";
        }
        ?>
    </table>
    
    <center><h2>Query with Hand-made Classes</h2>
    <h3>
    Query:<br>
    "SELECT * FROM tbl_users;"
    </h3>
    <hr>
    <table>
        <?php
        foreach ($pdostmt_users as $rslt_row) {            
            $id = $rslt_row["user_id"];
            $name = $rslt_row["username"];
            echo "<tr><td>$id</td><td>$name</td></tr>";            
        }
        ?>
    </table>
    </center>


<?php
include_once "./Public/snippets/footer.php";
?>
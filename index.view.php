<?php
?>

<html>
    <h1>Welcome Home</h1>
    <table>
        <?php
        foreach ($userlist as $userlist_row) {
            echo "<tr><td>$userlist_row->user_id</td><td>$userlist_row->username<td></tr>";
        }
        ?>
    </table>
</html>
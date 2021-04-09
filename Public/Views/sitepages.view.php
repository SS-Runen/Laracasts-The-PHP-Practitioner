<?php
# Planned feature is to have any URI found in database to be processsed and turned into
# clickable link to a site page. Cannot work with just `echo "<a href=$uri></a>";`.
?>
<html>
<head>Site Pages URI List</head>
<center><h2>Site Pages URI List</h2>
    <hr>
    <ul>
        <?php
        foreach ($pdostmt_sitepages as $rslt_row) {
            echo "<li>[".$rslt_row["uri"]."]</li>";
        }
        ?>
    </ul>
    </center>

<?php
include "./Public/snippets/footer.php";
?>
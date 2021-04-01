<?php
echo "<br><h3>SERVER:</h3>";
var_dump($_SERVER);
echo "<br><h3>POST:</h3>";
var_dump($_POST);
echo "<br><h3>GET:</h3>";
var_dump($_GET);

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
?>
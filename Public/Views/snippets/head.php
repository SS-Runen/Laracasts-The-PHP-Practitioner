<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>
    <?php echo array_slice(preg_split("[/]", $_SERVER["REQUEST_URI"]),-1)[0]; ?>
</title>

<link rel="stylesheet" type="text/css" href="/Public/css/general_style.css">

</head>
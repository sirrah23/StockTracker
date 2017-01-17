<?php

require("../common/header.php");

//Define variables
$username = $_POST["username"];
$password = $_POST["password"];

//Test
echo("<div id='content'>");
echo("Your username is ".$username."</br>");
echo("Your password is ".$password."\n"."</br>");
echo("</div>");

require("../common/footer.php");

?>

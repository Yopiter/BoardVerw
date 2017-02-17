<?php
$Cred=file_get_contents("Credentials.txt");
$Cred=  explode('|', $Cred);
$host=$Cred[0];
$user=$Cred[1];
$password=$Cred[2];
$database=$Cred[3];
$Verb=  mysqli_connect($host, $user, $password, $database) or die ("Keine Verbindung möglich");
mysqli_query($Verb, "SET NAMES 'utf8'");
?>

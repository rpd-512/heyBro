<?php
$dbhs = "";//host
$dbus = "";//username
$dbpw = "";//password
$dbnm = "heybro";
$pdo=new PDO('mysql:host='.$dbhs.';port=3306;dbname='.$dbnm.';charset=utf8',$dbus,$dbpw);
?>

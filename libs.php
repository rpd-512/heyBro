<?php
require_once "pdoData.php";

function hashCheck($value,$task,$pdo){
$ch = 0;
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if($task == "c"){if(md5($data['userId']."IamBack") == $value){return true;}}
else{if($data['usr'] == $value){return true;}}
}
return false;
}

function hashDetail($value,$task,$pdo){
$ch = 0;
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if($task=="c"){if(md5($data['userId']."IamBack") == $value){return $data;}}
else{if($data['usr'] == $value){return $data;}}

}
return false;
}

function isme($cookieValue, $getValue,$pdo)
{
if(hashDetail($cookieValue,"c",$pdo)['userId'] == hashDetail($getValue,"g",$pdo)['userId']){return true;}
return false;
}
?>

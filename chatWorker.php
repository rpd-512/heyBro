<?php
require_once "pdoData.php";
require_once "libs.php";

if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}
if(!isset($_COOKIE['userID']) or !hashCheck($_COOKIE['userID'],"c",$pdo)){setcookie('userID','',time());header("Location: index.php");exit();}

$meData = hashDetail($_COOKIE['userID'],"c",$pdo);

if(! isset($_POST['recv'])){

if(str_replace(" ","",$_POST['msg']) != ""){
echo $_POST['msg'];
$qry = "insert into messages (sendId,recvId,mesg) values(:sid,:rid,:msg)";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':sid' => $_POST['from'],
':rid' => $_POST['to'],
':msg' => $_POST['msg']
));}
}

if(isset($_POST['recv']))
{
$raw_data = $pdo->query("select * from messages where msgId > ".$_POST['last']);
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if($_POST['from'] == $data['sendId'] and $_POST['to'] == $data['recvId']){echo json_encode([$data['mesg'],$data['msgId']]);}
}
}
?>

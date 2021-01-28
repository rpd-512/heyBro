<?php
require_once "pdoData.php";
require_once "libs.php";
$err = "";
if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}
if(!isset($_COOKIE['userID']) or !hashCheck($_COOKIE['userID'],"c",$pdo)){setcookie('userID','',time());header("Location: index.php");exit();}

$meData = hashDetail($_COOKIE['userID'],"c",$pdo);
$reData = hashDetail($_GET['recv'],"g",$pdo);
if($meData['usr'] == $reData['usr']){header("Location: home.php");return;}

$raw_data = $pdo->query("select * from messages");
?>
<html>
<head>
<title>heyBro || Chat with <?= $reData['name']?></title>
<link rel="icon" type="image/png" href="images/favicon.png">
<script src="js/sketch.js"></script>
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Almendra SC' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Aladin' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Salsa' rel='stylesheet'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="header" style="background:black;border-radius:0px;margin-top:-130px;">
</div>
<div class="header"><br>
<button onclick="window.history.back();"><img src="images/back.svg"></button><br>
<span><?= $reData['name']?></span><br>
<span style="font-size:17px;">#<?= $reData['usr']?></span>
</div>

<div class="sendMsg">
<input type="text" autocomplete="off" id="msg">
<button onclick="sendMsg(<?= $meData['userId'] ?>,<?= $reData['userId'] ?>,document.getElementById('msg').value);document.getElementById('msg').value = ''"><img src="images/send.svg"></button>
</div>

<div class="chatWin" id="chatWin">
<br>
<center><span style="color:white;font-family:salsa;font-size:20px;">Talk freely :)<span>
</center>
<?php
$last = 0;
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if($data['sendId'] == $meData['userId'] and $data['recvId'] == $reData['userId'])
{
echo "<p class='send'>".$data['mesg']."</p>";
}
if($data['sendId'] == $reData['userId'] and $data['recvId'] == $meData['userId'])
{
echo "<p class='recv'>".$data['mesg']."</p>";
}
$last = $data['msgId'];
}
?>
<script>
last = <?= $last ?>;
</script>
<br><br></div>
</body>
<script src="js/sketch.js"></script>
<script>
function sendOnEnter(e){
if(e.key == "Enter"){
document.getElementById("sndMsg").click()}
}
</script>
<script>$(document).ready(function(){
window.scrollTo(0,document.body.scrollHeight);})
window.setInterval(
function(){recvMsg(<?= $reData['userId'] ?>,<?= $meData['userId'] ?>,last);},500);
</script>
</html>

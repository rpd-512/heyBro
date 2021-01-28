<?php
session_start();
require_once "libs.php";
require_once "pdoData.php";


if(!isset($_COOKIE['userID']) or !hashCheck($_COOKIE['userID'],"c",$pdo)){setcookie('userID','',time());header("Location: index.php");exit();}
$dataArr = hashDetail($_GET['user'],"g",$pdo);
$meArr = hashDetail($_COOKIE['userID'],"c",$pdo);

$err = "";
if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}

if(isset($_POST['frnd']))
{
$nexist = true;
$raw_data = $pdo->query("select * from friends where userId = ".$meArr['userId']." and frndId=".$dataArr['userId']);
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$nexist = false;
}

if($nexist)
{$qry = "insert into friends (frndId,userId) values(:frndId,:userId)";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':frndId' => $dataArr['userId'],
':userId' => $meArr['userId']
));
}
else{$qry = "delete from friends where frndId = :frndId and userId = :userId";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':frndId' => $dataArr['userId'],
':userId' => $meArr['userId']
));}
header("Location: home.php?user=".$_GET['user']);
}

if(!isset($_GET['user']) or !hashCheck($_GET['user'],"g",$pdo)){header("Location: home.php?user=".$meArr['usr']);}
$frndLst = [];
$raw_data = $pdo->query("select * from friends where userId = ".$meArr['userId']);
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
array_push($frndLst,$data['frndId']);
}
$isme = (isme($_COOKIE['userID'],$_GET['user'],$pdo))
?>
<html>

<head>
<?php
if($isme){echo "<title>HeyBro || Profile page</title>";}
else{echo "<title>HeyBro || ".$dataArr['name']."'s profile</title>";}
?>
<link rel="icon" type="image/png" href="images/favicon.png">
<script src="js/sketch.js"></script>
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Almendra SC' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Aladin' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Salsa' rel='stylesheet'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="homeHead homePage" style="border-bottom-right-radius:5px;border-bottom-left-radius:5px;">
<button class="setngs" onclick="location.href = 'settings.php'"><img src="images/settings.svg"></button>
<span class="topText"></span>
<div class="lgout">
<button onclick="location.replace('home.php');">Home</button>
<button onclick="lgout();">Logout</button>
</div>
<img class="topPicHome" src="images/favicon.png">
</div>
<div class="det" style="text-align:left;margin-top:10px;">
<form method="get" action="search.php" autocomplete="off">
<input id='srchQ' name="query" style="height:50px;width:calc(100% - 60px); font-family:aladin" placeholder="Search with name or user ID">
<button type="submit" class='searchBut' onclick="return checkSearch()"><img src="images/search.svg"></button>
</form>
</div>

<div class="homeFoot">
<p id="summary"></p>
</div>
<div class="aftLgin">
<div class="allinfo">
<span class="topText">Info</span>
<div class="info">
<span>Name:</span> <span class="det"><?= $dataArr['name'] ?></span><br>
<span>User ID:</span> <span class="det">#<?= $dataArr['usr'] ?></span><br>
</div>
</div><br>
<?php
$add = "Add Friend";
if(in_array($dataArr['userId'],$frndLst)){$add="Added";}
if($isme){
echo '
<div class="friends">
<span class="topText">Friends List</span><br>
<div class="list numb"><br>';
$raw_data = $pdo->query("select * from userData");
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
if(in_array($data['userId'],$frndLst)){
echo "<button onclick=\"location.href='home.php?user=".$data['usr']."'\">#".$data['usr']." | ".$data['name']."</button><br><br>";}
}
echo "</div>";
}

else{
echo '
<div class="addfrnd">
<span class="topText" style="font-size:40px;">Add to friend list</span>
<br>
<form action="home.php?user='. $_GET['user'] .'" method="post">
<button type="submit" name="frnd" value="'.$dataArr['userId'].'">'.$add.'</button><br>
<button type="button" style="margin-top:10px;" onclick="location.href=\'chat.php?recv='.$dataArr['usr'].'\'">Chat</button>
</form>
</div>
';
}
?>
<script src="js/sketch.js">
</body>
<?= $err;?>
</html>

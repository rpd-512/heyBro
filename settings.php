<?php
session_start();
require_once "pdoData.php";
require_once "libs.php";
$err = "";
if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}
if(!isset($_COOKIE['userID']) or !hashCheck($_COOKIE['userID'],"c",$pdo)){setcookie('userID','',time());header("Location: index.php");exit();}

$meData = hashDetail($_COOKIE['userID'],"c",$pdo);

if(isset($_POST['sav']))
{
$qry = "update userData set name = :name, mail = :mail where userId = ".$meData['userId'];
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':name' => htmlentities($_POST['name']),
':mail' => htmlentities($_POST['mail'])
));
$_SESSION['err'] = "<script>alert('Data updated');</script>";
header("Location: settings.php");
}
?>
<html>
<head>
<title>HeyBro || Settings</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.5.11/p5.min.js"></script>
<script src="js/sketch.js"></script>
<link rel="icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Almendra SC' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Aladin' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Salsa' rel='stylesheet'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="homeHead" style="height:275px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;">
<img src="images/favicon.png"><br>
<div class="home">
<button onclick="if(confirm('Are you sure you saved the changes??')){location.href = 'home.php';}">Home</button>
</div>
</div>
<br>

<div class="settings">
<br>
<form method="post" autocomplete="off">
<span>Name <input name="name" id="name" value="<?= $meData['name'] ?>" ></span><br><br>
<span>Email <input name="mail" id="mail" value="<?= $meData['mail'] ?>" ></span><br><br><br>
<button onclick="return saveDet()" name="sav">Save</button><br><br>
<button type="button" onclick="location.href='change_password.php'">Change Password</button><br><br>
<button type="button" onclick="location.href='delete_account.php'">Delete account</button><br><br>
</form>
</div>
</div>
<script src="js/sketch.js"></script>
<?= $err ?>
</body>
</html>

<?php
$eyeNee = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19.604 2.562l-3.346 3.137c-1.27-.428-2.686-.699-4.243-.699-7.569 0-12.015 6.551-12.015 6.551s1.928 2.951 5.146 5.138l-2.911 2.909 1.414 1.414 17.37-17.035-1.415-1.415zm-6.016 5.779c-3.288-1.453-6.681 1.908-5.265 5.206l-1.726 1.707c-1.814-1.16-3.225-2.65-4.06-3.66 1.493-1.648 4.817-4.594 9.478-4.594.927 0 1.796.119 2.61.315l-1.037 1.026zm-2.883 7.431l5.09-4.993c1.017 3.111-2.003 6.067-5.09 4.993zm13.295-4.221s-4.252 7.449-11.985 7.449c-1.379 0-2.662-.291-3.851-.737l1.614-1.583c.715.193 1.458.32 2.237.32 4.791 0 8.104-3.527 9.504-5.364-.729-.822-1.956-1.99-3.587-2.952l1.489-1.46c2.982 1.9 4.579 4.327 4.579 4.327z"/></svg>';
session_start();
require_once "pdoData.php";
require_once "libs.php";
$err = "";
if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}
if(!isset($_COOKIE['userID']) or !hashCheck($_COOKIE['userID'],"c",$pdo)){setcookie('userID','',time());header("Location: index.php");exit();}

$meData = hashDetail($_COOKIE['userID'],"c",$pdo);

if(isset($_POST['chng']))
{
if(md5($_POST['pswd']."incognitoBOI") == $meData['pswd'])
{
$qry = "delete from userData where userId = :usrId";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':usrId' => $meData['userId']
));

$qry = "delete from friends where userId = :usrId or frndId = :usrId";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':usrId' => $meData['userId']
));

$_SESSION['err'] = "<script>alert('Account deleted');</script>";
header("Location: index.php");return;
}

else{
$_SESSION['err'] = "<script>alert('incorrect password');</script>";
header("Location: delete_account.php");return;
}

}
?>
<html>
<head>
<title>HeyBro</title>
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
<button onclick="location.href = 'settings.php';">Back</button>
</div>
</div>
<br>
<div class="deleteAcc">
<form method="post">
<input name="pswd" placeholder="Enter password" type="password" id="mpwd">
<button name="chng" onclick="return updtPswd()">Delete</button><br>
</form>
<p id="summary"></p>
</div>
<script src="js/sketch.js"></script>
<script>
var i = 0;var txt1 = "It is really sad to see you go :(<br>We hope you come back.<br><br>NOTE: this account could never be recovered later";var speed = 20;function typeWriter() {if (i < txt1.length) {try{if(txt1.charAt(i)+txt1.charAt(i+1)+txt1.charAt(i+2)+txt1.charAt(i+3) == "<br>"){document.getElementById("summary").innerHTML += "<br>";i+=4;}else{document.getElementById("summary").innerHTML += txt1.charAt(i);i++;}}catch{document.getElementById("summary").innerHTML += txt1.charAt(i);i++;}setTimeout(typeWriter, speed);}}setTimeout(typeWriter(), 1000);
</script>
<?= $err;?>
</body>
</html>

<?php
require_once "libs.php";
require_once "pdoData.php";
if(isset($_COOKIE['userID']) and hashCheck($_COOKIE['userID'],"c",$pdo)){header("Location: home.php");}

session_start();
$eyeNee = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M19.604 2.562l-3.346 3.137c-1.27-.428-2.686-.699-4.243-.699-7.569 0-12.015 6.551-12.015 6.551s1.928 2.951 5.146 5.138l-2.911 2.909 1.414 1.414 17.37-17.035-1.415-1.415zm-6.016 5.779c-3.288-1.453-6.681 1.908-5.265 5.206l-1.726 1.707c-1.814-1.16-3.225-2.65-4.06-3.66 1.493-1.648 4.817-4.594 9.478-4.594.927 0 1.796.119 2.61.315l-1.037 1.026zm-2.883 7.431l5.09-4.993c1.017 3.111-2.003 6.067-5.09 4.993zm13.295-4.221s-4.252 7.449-11.985 7.449c-1.379 0-2.662-.291-3.851-.737l1.614-1.583c.715.193 1.458.32 2.237.32 4.791 0 8.104-3.527 9.504-5.364-.729-.822-1.956-1.99-3.587-2.952l1.489-1.46c2.982 1.9 4.579 4.327 4.579 4.327z"/></svg>';
$err = "";
if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}
$raw_data = $pdo->query("select * from userData");
if(isset($_POST['mail'])){
$usrnLst = array();
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
array_push($usrnLst,$data['usr']);
if(strtolower($_POST['mail']) == strtolower($data['mail'])){$_SESSION['err']="<script>alert('Email address already taken');</script>";header("Location: signup.php");return;};
}
}
if(isset($_POST['name'])){

$cond = false;
while(!$cond)
{
$usrn = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
if(! in_array($usrn,$usrnLst)){$cond = true;}
}

$pswd = md5($_POST['pass']."incognitoBOI");
$name = $_POST['name'];
$mail = $_POST['mail'];
$qry = "insert into userData (name,mail,pswd,usr) values(:name, :mail, :pswd, :user)";
$raw_data = $pdo->prepare($qry);
$raw_data->execute(array(
':name' => htmlentities($name),
':mail' => htmlentities($mail),
':pswd' => htmlentities($pswd),
':user' => htmlentities($usrn)
));
$_SESSION['err'] = "<script>alert('Successfully signed up! Congratulations!');</script>";
header("Location: signin.php");
}

if(isset($_POST['back'])){header("Location: index.php");}
?>
<html>
<head>
<title>HeyBro || Sign Up</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.5.11/p5.min.js"></script>
<link rel="icon" type="image/png" href="images/favicon.png">
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Almendra SC' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Aladin' rel='stylesheet'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="homeHead" style="height:525px;">
<img src="images/favicon.png">
<div class="det">
<form method="post" id="mainForm">
<input placeholder="Name" autocomplete="off" name='name' id='name'><br><br>
<input placeholder="Email" autocomplete="off" name='mail' id='mail'><br><br>
<input placeholder="Password" type="password" name='pass' id='pswd'><button type="button" id="eyeP" onclick="pswdView();"><?=$eyeNee?></button><br><br>
<input placeholder="Confirm password" type="password" name='cpass' id='cpwd'><br><br>
</form>
<form method="post" id="backForm"></form>
<input type="submit" name='back' value="Back" form="backForm"> <input type="submit" value="SignUp" onclick="return checkDetSignup();" form="mainForm">
</form>
</div>
</div>
<div class="homeFoot">
<p id="summary"></p>
</div>
</body>

<?= $err ?>
<script src="js/sketch.js"></script>
<script>
var i = 0;var txt1 = 'Thank you for signing up, I hope you enjoy the site.';var speed = 20;function typeWriter() {if (i < txt1.length) {try{if(txt1.charAt(i)+txt1.charAt(i+1)+txt1.charAt(i+2)+txt1.charAt(i+3) == "<br>"){document.getElementById("summary").innerHTML += "<br>";i+=4;}else{document.getElementById("summary").innerHTML += txt1.charAt(i);i++;}}catch{document.getElementById("summary").innerHTML += txt1.charAt(i);i++;}setTimeout(typeWriter, speed);}}setTimeout(typeWriter(), 1000);
</script>

</html>

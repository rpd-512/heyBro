<?php
session_start();
require_once "libs.php";
require_once "pdoData.php";
if(isset($_COOKIE['userID']) and hashCheck($_COOKIE['userID'],"c",$pdo)){header("Location: home.php");}
$err = "";
if(isset($_SESSION['err'])){$err = $_SESSION['err'];unset($_SESSION['err']);}
?>
<html>
<head>
<title>HeyBro</title>
<link rel="icon" type="image/png" href="images/favicon.png">
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.5.11/p5.min.js"></script>
<script src="js/sketch.js"></script>
<link rel="stylesheet" href="css/style.css">
<link href='https://fonts.googleapis.com/css?family=Almendra SC' rel='stylesheet'>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="homeHead">
<h1>Hey Bro</h1>
<img src="images/favicon.png">
<div class="sign">
<a href="signin.php">SignIn</a>
<a href='signup.php'>SignUp</a>
</div>
</div>
<div class="homeFoot">
<p id="summary"></p>
</div>
</body>

<script>
var i = 0;var txt1 = 'HeyBro is an experimental web based chat application, <br>Developed by Rhiddhi Prasad Das.<br>Feel free to use it  :)';var speed = 20;function typeWriter() {if (i < txt1.length) {try{if(txt1.charAt(i)+txt1.charAt(i+1)+txt1.charAt(i+2)+txt1.charAt(i+3) == "<br>"){document.getElementById("summary").innerHTML += "<br>";i+=4;}else{document.getElementById("summary").innerHTML += txt1.charAt(i);i++;}}catch{document.getElementById("summary").innerHTML += txt1.charAt(i);i++;}setTimeout(typeWriter, speed);}}setTimeout(typeWriter(), 1000);
</script>
<?= $err ?>
</html>

<?php
require_once "libs.php";
require_once "pdoData.php";
if(!isset($_COOKIE['userID']) or !hashCheck($_COOKIE['userID'],"c",$pdo)){setcookie('userID','',time());header("Location: index.php");exit();}

if(isset($_GET['query']))
{
if(strpos($_GET['query'],"#") !== false){$raw_data = $pdo->query("select * from userData where usr like '%".str_replace("#","",$_GET['query'])."%'");$val = $_GET['query'];}
else{$raw_data = $pdo->query("select * from userData where name like '%".$_GET['query']."%'");$val = $_GET['query'];}
}
else{$raw_data = $pdo->query("select * from userData");$val = "";}

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
<div class="homeHead" style="height:310px;border-bottom-right-radius:5px;border-bottom-left-radius:5px;">
<img src="images/favicon.png"><br>
<div class="home">
<button onclick="location.href = 'home.php';">Home</button>
</div>
<div class="det" style="text-align:left;margin-top:10px;">
<form method="get" action="search.php">
<input id='srchQ' value="<?= $val ?>" name="query" style="height:50px;width:calc(100% - 60px); font-family:aladin" placeholder="Search with name or user ID (To find a user with user ID, use # in front)">
<button type="submit" class='searchBut' onclick="return checkSearch()"><img src="images/search.svg" style="width:30px;"></button>
</form>
</div>
</div>
<br>
<center>
<div class="searchRes" style="text-align:center;"><br>
<span style="color:white;font-family:salsa;font-size:15px;">To find a user with user ID, use "#" before the ID</span>
<div class="resultsearch">
<?php
$exst = false;
while ($data = $raw_data->fetch(PDO::FETCH_ASSOC))
{
$exst = true;
echo "<button onclick=\"location.replace('home.php?user=".$data['usr']."')\">#".$data['usr']." | ".$data['name']."</button><br><br>";
}
if(! $exst){
echo "<br><span class='noresults'>No results :(</span><br><br>";
}
?>
</div>
</div>
</center>
</body>

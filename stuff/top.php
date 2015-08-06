<?php
session_start();
require('connect.php');
require('functions.php');
$query1 = mysql_query("SELECT * FROM `promo` ORDER BY `id` DESC LIMIT 1") or die(mysql_error());
$result1 = mysql_fetch_array($query1);
$q1 = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$r1 = mysql_fetch_array($q1);
if($r1['rank']=="Banned") {
echo "";
die();
}
else {
}
$time = time();
$date = date('d/m/y');
$updatet = mysql_query("UPDATE `users` SET `time`='".$time."' WHERE `id`='".$_SESSION['id']."'");
$updated = mysql_query("UPDATE `users` SET `date`='".$date."' WHERE `id`='".$_SESSION['id']."'");
?>
<head>
<title>The Pokemon Comet Version 0.1 - Created By: Shadow</title>
<link rel='stylesheet' type='text/css' href='stuff/style.css'>
<link rel="shortcut icon" href="images/sprites/etc/favo_icon.png" />
<script src='stuff/jquery.js' language='javascript' type='text/javascript'></script>
<script src='stuff/main.js' language='javascript' type='text/javascript'></script>
</head>
<body>
<script src='stuff/tooltip.js' language='javascript' type='text/javascript'></script>
<div id='centerlayout'>
<table cellspacing='0' style='text-align: center' cellpadding='0' width='800px' align='center' valign='top'>
<tr><td colspan='3' id='banner' cellspacing='0' valign='top' align='center' cellpadding='0' border='1' onmouseover="Tip('Banner')" onmouseout="UnTip()">&nbsp;</td></tr>
<tr><td colspan='1' id='leftmenu' cellspacing='0' cellpadding='0' valign='top'>
<?php 
if(isset($_SESSION['id'])) {
?>
<h1>Main</h1>
<a href='index.php'>Index</a><br>
<a href='news.php?select=news'>News</a><br>
<a href='news.php?select=comments'>News Comments</a><br>
<?php
if($r1['rank']=="Administrator" || $r1['rank']=="Moderator") {
echo "<a href='news.php?select=post'>Post News</a><br>
<a href='news.php?select=editnews'>Edit News</a><br>";
}
else {
echo "";
}
?>
<a href='http://xat.com/ThePokemonComet' target='_blank'>Chat</a><br>
<a href='/boards/index.php'>Forums</a><br>
<a href='logout.php'>Logout</a><br><br>
<h1>Promo</h1>
<a href='promo.php'><img src="images/sprites/<?php echo $result1['picture']; ?>.png" title='Click to Obtain Promo' alt='Promo' /></a><br>
<h1>Referrals</h1>
<a href='youref.php'>Referral Center</a>
<?php
}
else {
?>
<h1>Main</h1>
<a href='index.php'>Homepage</a><br>
<a href='register.php'>Sign Up</a><br>
<a href='login.php'>Login</a>
<?php
}
?>
</td>
<td colpsan='1' id='center' cellspacing='0' cellpadding='0' valign='top'>
<h1>Pokemon Comet RPG</h1>

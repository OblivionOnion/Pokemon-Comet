<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
echo "You are unallowed to view this page.";
}
else {
$var = safe($_GET['ref']);
$qref = mysql_query("SELECT * FROM `users` WHERE `id`='".$var."'");
$ref = mysql_fetch_array($qref);
if(isset($_POST['submit'])) {
$uname = $_POST['nacho'];
$pass = safe($_POST['pass']);
$conf_pass = safe($_POST['conf_pass']);
$email = safe($_POST['email']);
$code = safe($_POST['code']);
$emailopt = safe($_POST['emailopt']);
$starter = safe($_POST['starter']);
$ip = $_SERVER['REMOTE_ADDR'];
if($uname=='') {
$error = "Please enter a legit name.";
}
elseif($pass != $conf_pass) {
$error = "The passwords do not match.";
}
elseif($code != $_SESSION['code']) {
$error = "The codes do not match.";
}
elseif($email=='') {
$error = "Please enter an email address.";
}
else {
$query1 = mysql_query("SELECT * FROM `users` WHERE `ip`='".$ip."'");
$check1 = mysql_num_rows($query1);
$query2 = mysql_query("SELECT * FROM `users` WHERE `name`='".$uname."'");
$check2 = mysql_num_rows($query2);
$query3 = mysql_query("SELECT * FROM `users` WHERE `email`='".$email."'");
$check3 = mysql_num_rows($query3);
if($check1 >= '2') {
$error = "Only two(2) accounts per IP.";
}
elseif($check2 >= '1') {
$error = "That name is already in use, try again.";
}
elseif($check3 >= '1') {
$error = "That email is already in use, try again.";
}
else {
if($starter != "Chikorita" && $starter != "Cyndaquil" && $starter != "Totodile") {
$error = "Please choose a legit starter";
}
else {
$refpoints = $ref['ref'];
$refpointsadd = rand(1,3);
$refpointsnow = $refpoints+$refpointsadd;
$updateref = mysql_query("UPDATE `users` SET `ref`='".$refpointsnow."' WHERE `id`='".$ref['id']."'");
$pass2 = sha1($pass);
mysql_query("INSERT INTO `pokemon` (`name`, `type`, `owner`, `level`, `position`) VALUES ('".$starter."', 'Normal', '".$uname."', '5', '1')") or die(mysql_error());
mysql_query("INSERT INTO `users` (`name`, `pass`, `email`, `emailopt`, `ip`) VALUES ('".$uname."', '".$pass2."', '".$email."', '".$emailopt."', '".$ip."')") or die(mysql_error());
echo "You have successfully registered ";
echo $uname;
echo ". Click <a href='login.php'>here</a> to login.";
require('stuff/bottom.php');
exit();
}
}
}
}
else {
$error = '';
}
$md5 = md5(rand(1,999));
$code = substr($md5, 10, 5); 
$_SESSION['code'] = $code;
?>
<body OnLoad="showButton('Register');">
Welcome to the sign up page. Here you can sign up for the RPG to start playing it. If you already have an account, please click <a href='login.php'>here</a> to log in.
<br>
<form action="<?php if(isset($_GET['ref'])) {
echo "register.php?ref=".$ref['id']."";
}
else {
echo safe($_SERVER['PHP_SELF']);
}
?>" method='post'><table style='border: 1px solid black;' width='95%' cellpadding='1' cellspacing='1' align='center'>
<tr><td width='95%' style='border: 1px solid black;' colspan='2'><?php 
if($error=='') {
echo "No errors";
}
else {
echo $error;
}
?></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Username</b></td><td width='65%' style='border: 1px solid black;'><input type='text' name='nacho' maxlength='50'></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Password</b></td><td width='65%' style='border: 1px solid black;'><input type='password' name='pass' maxlength='25'></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Confirm Password</b></td><td width='65%' style='border: 1px solid black;'><input type='password' name='conf_pass' maxlength='25'></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Email</b></td><td width='65%' style='border: 1px solid black;'><input type='text' name='email' maxlength='50'></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Show/Hide Email</b></td><td width='65%' style='border: 1px solid black;'>
<select name='emailopt'>
<option value='Show' selected='selected'>Show</option>
<option value='Hide'>Hide</option>
</select></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Code: <?php echo $code; ?></b></td><td width='65%' style='border: 1px solid black;'><input type='text' name='code' maxlength='25'></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Starter</b></td><td width='65%' style='border: 1px solid black;'>
<select name='starter'>
<option value='Chikorita' selected='selected'>Chikorita</option>
<option value='Cyndaquil'>Cyndaquil</option>
<option value='Totodile'>Totodile</option>
</select></td></tr>
<tr><td width='95%' style='border: 1px solid black;' colspan='2'><div id='button_place'>Please enable Javascript</div></td></tr>
</table></form>
<?php
}
require('stuff/bottom.php');
?>

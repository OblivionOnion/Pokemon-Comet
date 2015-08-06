<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
echo "You are unallowed to view this page.";
} 
else {
if(isset($_POST['submit'])) {
$username = safe($_POST['username']);
$pass = safe(sha1($_POST['pass']));
$query1 = mysql_query("SELECT * FROM `users` WHERE `name`='".$username."'");
$result1 = mysql_fetch_array($query1);
$check1 = mysql_num_rows($query1);
if($pass != $result1['pass']) {
$error = "The password does not match the password provided.";
}
elseif($check1=='') {
$error = "The username provided does not exist.";
}
elseif($pass=='') {
$error = "Please enter a password.";
}
else {
if($username=='') {
$error = "Please enter a username.";
}
else {
echo "You have successfully been logged in. Please click <a href='index.php'>here</a> to go to the index page.";
require('stuff/bottom.php');
$_SESSION['id'] = $result1['id'];
$_SESSION['name'] = $result1['name'];
die();
}
}
}
else {
$error = '';
}
?>
<body onLoad="showButton('Login');">
Here you can login to the RPG if you already have an account <a href='register.php'>registered</a>.<br>
<form action="<?php echo safe($_SERVER['PHP_SELF']); ?>" method='post'><table style='border: 1px solid black;' width='95%' cellpadding='1' cellspacing='1' align='center'>
<tr><td width='95%' style='border: 1px solid black;' colspan='2'><?php
if($error=='') {
echo "No errors.";
}
else {
echo $error;
}
?></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Username</b></td><td width='65%' style='border: 1px solid black;'><input type='text' name='username' maxlength='25'></td></tr>
<tr><td width='30%' style='border: 1px solid black;'><b>Password</b></td><td width='65%' style='border: 1px solid black;'><input type='password' name='pass' maxlength='25'></td></tr>
<tr><td width='95%' style='border: 1px solid black;' colspan='2'><div id='button_place'>Please enable Javascript<br>If Javascript is enabled, then please wait for the page to fully load.</div></td></tr>
</table></form>
<?php
}
require('stuff/bottom.php');
?>

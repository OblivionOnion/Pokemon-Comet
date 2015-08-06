<?php
require('stuff/top.php');
$q = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$r = mysql_fetch_array($q);
if($r['rank'] != "Member") {
if(isset($_POST['chg'])) {
$name = safe($_POST['pname']);
$type = safe($_POST['type']);
$pic = safe($_POST['pic']);
$icon = safe($_POST['icon']);
mysql_query("INSERT INTO `promo` (`name`, `type`, `picture`, `icon`) VALUES ('".$name."', '".$type."', '".$pic."', '".$icon."')") or die(mysql_error());
mysql_query("UPDATE `users` SET `promo`='0'");
echo "Promo has been changed to ".$name.".";
}
else {
?>
<form action="<?php echo safe($_SERVER['PHP_SELF']); ?>" method='post'>
<b>Name:</b><br>
<input type='text' name='pname'>
<br><br>
<b>Type:</b><br>
<input type='text' name='type'>
<br><br>
<b>Picture</b><br>
<input type='text' name='pic'>
<br><br>
<b>Icon</b><br>
<input type='text' name='icon'>
<br><input type='submit' name='chg' value='Change Promo!'>
</form>
<?php
}
}
else {
echo "You are unallowed to view this page.";
}
require('stuff/bottom.php');
?>

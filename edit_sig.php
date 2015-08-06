<?php
require('stuff/top.php');
$q = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$r = mysql_fetch_array($q);
if(isset($_POST['submit'])) {
$sig = safe(stripslashes($_POST['sig']));
$u = mysql_query("UPDATE `users` SET `sig`=\"".$sig."\" WHERE `id`='".$_SESSION['id']."'");
echo "Sig successfully changed!";
}
else {
?>
Here you can edit your signature.<br>
BBCode and Smilies work.<br>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
<textarea name='sig' rows='10' cols='50'><?php echo $r['sig']; ?></textarea><br>
<input type='submit' name='submit' value='Edit!'>
</form>
<?php
}
require('stuff/bottom.php');
?>

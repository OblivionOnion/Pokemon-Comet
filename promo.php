<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
$query = mysql_query("SELECT * FROM `promo` ORDER BY `id` DESC LIMIT 1") or die(mysql_error());
$result = mysql_fetch_array($query);
$query2 = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$result2 = mysql_fetch_array($query2);
if($result2['promo']=="0") {
if(isset($_POST['submit'])) {
$rand = rand(1,10);
mysql_query("INSERT INTO `pokemon` (`name`, `type`, `owner`, `level`, `position`) VALUES ('".$result['name']."', '".$result['type']."', '".$_SESSION['name']."', '".$rand."', '".$spot."')") or die(mysql_error());
mysql_query("UPDATE `users` SET `promo`='1' WHERE `id`='".$_SESSION['id']."'");
$cur = $result['num_obtained'];
$gain = $cur+1;
$update = mysql_query("UPDATE `promo` SET `num_obtained`='".$gain."' WHERE `id`='".$result['id']."'");
echo "You have just obtained the current promo, ".$result['name']."";
}
else {
echo "<table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'>
<tr><td width='90%' style='border: 1px solid black;'>Current Promo: ".$result['name']."</td></tr>
<tr><td width='90%' style='border: 1px solid black;'><img src=\"images/sprites/".$result['picture'].".png\" alt='Promo' /></td></tr>
<tr><td width='90%' style='border: 1px solid black;'><form action='";
echo safe($_SERVER['PHP_SELF']);
echo "' method='post'>
<input type='submit' name='submit' value='Obtain Promo!'>
</form></td></tr></table>";
}
}
else {
echo "<table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'>
<tr><td width='90%' style='border: 1px solid black;'>Current Promo: ".$result['name']."</td></tr>
<tr><td width='90%' style='border: 1px solid black;'><img src=\"images/sprites/".$result['picture'].".png\" alt='Promo' /></td></tr>
<tr><td width='90%' style='border: 1px solid black;'>
<input type='submit' name='obtained already' disabled='true' value='Already Obtained!'>
</form></td></tr></table>";
}
}
else {
echo "You are unallowed to view this page.";
}
require('stuff/bottom.php');
?>

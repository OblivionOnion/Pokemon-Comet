<?php 
require('stuff/top.php');
if(isset($_SESSION['id'])) {
$query = mysql_query("SELECT * FROM `trades` WHERE `status`='pending' AND `otherid`='".$_SESSION['id']."'");
$check = mysql_num_rows($query);
?>
Welcome to The Pokemon Comet RPG. You are officially logged in.<br><br>
<u>Alerts:</u><br>
You have <?php echo $check; ?> new trade requests.
<?php
}
else {
?>
Welcome to The Pokemon Comet RPG.<br>
Click a link on the sidebars to continue.
<?php
}
require('stuff/bottom.php');
?>

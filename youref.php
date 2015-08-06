<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
$que = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$res = mysql_fetch_array($que);
?>
Welcome to the Referral Center.<br>
You currently have <?php echo $res['ref']; ?> Referral Points.<br><br>
To get more Referral Points, have unregistered users sign up at this link:
http://pcomet.comeze.com/register.php?ref=<?php echo $_SESSION['id']; ?><br>
<font color='red'><b>IF you are caught cheating referrals, you and your other accounts will be IP banned immediately.</b></font>
<?php
}
else {
echo "You are unallowed to view this page.";
}
require('stuff/bottom.php');
?>

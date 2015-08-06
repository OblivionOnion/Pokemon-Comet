<?php
require('stuff/top.php');
$var = safe($_GET['stat']);
if($var=="pokemon") {
$query = mysql_query("SELECT * FROM `pokemon` ORDER BY `level` DESC LIMIT 20");
echo "<table border='1' width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'>
<tr><th width='25%' style='border: 1px solid black;'>Pokemon ID</th><th width='25%' style='border: 1px solid black;'>Pokemon Name</th><th width='25%' style='border: 1px solid black;'>Pokemon Owner</th><th width='15%' style='border: 1px solid black;'>Level</th></tr>";
while($row = mysql_fetch_array($query)) {
$user = mysql_query("SELECT * FROM `users` WHERE `name`='".$row['owner']."'");
$res = mysql_fetch_array($user);
if($res['rank']=="Banned") {
echo "";
}
else {
echo "<tr><td width='25%' style='border: 1px solid black;'>";
echo $row['id'];
echo "</td><td width='25%' style='border: 1px solid black;'>";
echo $row['name'];
echo "</td><td width='25%' style='border: 1px solid black;'>";
echo $row['owner'];
echo "</td><td width='15%' style='border: 1px solid black;'>";
echo $row['level'];
echo "</td></tr>";
}
}
echo "</table>";
}
else {
echo "Does not exist.";
}
require('stuff/bottom.php');
?>

<?php
require('stuff/top.php');
$time = time();
$time2 = $time-300;
$date = date('d/m/y');
$query2 = mysql_query("SELECT * FROM `users` WHERE `date`='".$date."' AND `time`>='".$time2."' ORDER BY `id` ASC");
echo "<table width='90%' align='center' style='border: 1px solid black;'><tr><th width='20%' style='border: 1px solid black;'>User ID</th><th width='40%' style='border: 1px solid black;'>User Name</th><th width='30%' style='border: 1px solid black;'>User Rank</th></tr>";
while($row = mysql_fetch_array($query2)) {
echo "<tr><td width='20%' style='border: 1px solid black;'>";
echo $row['id'];
echo "</td><td width='50%' style='border: 1px solid black;'>";
echo $row['name'];
echo "</td><td width='30%' style='border: 1px solid black;'>";
echo rank($row['rank']);
echo "</td></tr>";
}
echo "</table>";
require('stuff/bottom.php');
?>

<?php
require('require/top.php');
if(isset($_SESSION['id'])) {
$q1 = mysql_query("SELECT * FROM `cats`");
while($row1 = mysql_fetch_array($q1)) {
$q2 = mysql_query("SELECT * FROM `forums` WHERE `category`='".$row1['id']."'");
echo "<fieldset><legend>".$row1['name']."</legend><table width='100%' cellpadding='1' cellspacing='1' style='text-align: center; border: 1px solid black;'><tr><th width='60%' style='border: 1px solid black;'>Name/Description</th><th width='20%' style='border: 1px solid black;'>Threads</th><th width='20%' style='border: 1px solid black;'>Posts</th></tr>";
while($row2 = mysql_fetch_array($q2)) {
$q3 = mysql_query("SELECT * FROM `posts` WHERE `forum`='".$row2['id']."' AND `type`='topic'");
$n3 = mysql_num_rows($q3);
$q4 = mysql_query("SELECT * FROM `posts` WHERE `forum`='".$row2['id']."' AND `type`='post'");
$n4 = mysql_num_rows($q4);
echo "<tr>
<td width='60%' style='border: 1px solid black;'><a href='viewforum.php?id=".$row2['id']."'>".$row2['name']."</a><br><i>
".$row2['description']."</i></td><td width='20%' style='border: 1px solid black;'>".$n3."</td><td width='20%' style='border: 1px solid black;'>".$n4."</td></tr>";
}
echo "</table></fieldset><br>";
}
}
else {
echo "Please login first.";
}
require('require/bottom.php');
?>

<?php
require('require/top.php');
if(isset($_SESSION['id'])) {
$var = safe($_GET['id']);
$q1 = mysql_query("SELECT * FROM `forums` WHERE `id`='".$var."'");
$r1 = mysql_fetch_array($q1);
$c1 = mysql_num_rows($q1);
if($c1=="1") {
$q2 = mysql_query("SELECT * FROM `posts` WHERE `forum`='".$r1['id']."' AND `type`='topic' AND `sticky`='0' ORDER BY `lastpost` DESC");
echo "<table width='98%' cellpadding='1' style='text-align: center; border: 1px solid black;' cellspacing='1' align='center'>
<tr><td width='100%' style='border: 1px solid black;' colspan='4'><a href='../boards'>Index</a> --> <a href='../boards/viewforum.php?id=".$r1['id']."'>".$r1['name']."</a></td></tr>
<tr><th width='30%' style='border: 1px solid black;'>Topic Title</th><th width='30%' style='border: 1px solid black;'>Topic Poster</th><th width='20%' style='border: 1px solid black;'>Replies</th><th width='20%' style='border: 1px solid black;'>Views</th></tr>";
$q4 = mysql_query("SELECT * FROM `posts` WHERE `forum`='".$r1['id']."' AND `type`='topic' AND `sticky`='1' ORDER BY `lastpost` DESC");
while($row2 = mysql_fetch_array($q4)) {
$q5 = mysql_query("SELECT * FROM `posts` WHERE `topic`='".$row2['id']."' AND `type`='post'");
$n5 = mysql_num_rows($q5);
echo "<tr><td width='30%' style='border: 1px solid black;'><a href='viewtopic.php?id=".$row2['id']."'><strong>".$row2['title']."</strong></a></td>
<td width='30%' style='border: 1px solid black;'>".$row2['poster']."</td>
<td width='20%' style='border: 1px solid black;'>".$n5."</td>
<td width='20%' style='border: 1px solid black;'>".$row2['views']."</td>
</tr>";
}
while($row1 = mysql_fetch_array($q2)) {
$q3 = mysql_query("SELECT * FROM `posts` WHERE `topic`='".$row1['id']."' AND `type`='post'");
$n3 = mysql_num_rows($q3);
echo "<tr><td width='30%' style='border: 1px solid black;'><a href='viewtopic.php?id=".$row1['id']."'>".$row1['title']."</a></td>
<td width='30%' style='border: 1px solid black;'>".$row1['poster']."</td>
<td width='20%' style='border: 1px solid black;'>".$n3."</td>
<td width='20%' style='border: 1px solid black;'>".$row1['views']."</td>
</tr>";
}
echo "<tr><td width='100%' colspan='4' style='border: 1px solid black; text-align: right;'><a href='newtopic.php?for=".$r1['id']."'>New Topic</a></td></tr></table>";
}
else {
echo "This forum does not exist.";
}
}
else {
echo "Please login first.";
}
require('require/bottom.php');
?>

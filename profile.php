<?php
require('stuff/top.php');
$var = safe($_GET['id']);
$query = mysql_query("SELECT * FROM `users` WHERE `id`='".$var."'");
$result = mysql_fetch_array($query);
$check = mysql_num_rows($query);
if($check=="1") {
$s1 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='1'");
$r1 = mysql_fetch_array($s1);
$c1 = mysql_num_rows($s1);
$sd1 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r1['name']."'");
$rd1 = mysql_fetch_array($sd1);
if($c1=="1") {
$slot1 = "images/sprites/".$rd1['picture'].".png";
$stats1 = "Level: ".$r1['level']."<br>EXP: ".$r1['exp']."";
$link1 = "<a href='battle.php?select=create&opp=".$r1['id']."'>Slot 1</a>";
}
else {
$slot1 = "images/maps/nothing.png";
$stats1 = "Empty";
$link1 = "Slot 1";
}

$s2 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='2'");
$r2 = mysql_fetch_array($s2);
$c2 = mysql_num_rows($s2);
$sd2 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r2['name']."'");
$rd2 = mysql_fetch_array($sd2);
if($c2=="1") {
$slot2 = "images/sprites/".$rd2['picture'].".png";
$stats2 = "Level: ".$r2['level']."<br>EXP: ".$r2['exp']."";
$link2 = "<a href='battle.php?select=create&opp=".$r2['id']."'>Slot 2</a>";
}
else {
$slot2 = "images/maps/nothing.png";
$stats2 = "Empty";
$link2 = "Slot 2";
}

$s3 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='3'");
$r3 = mysql_fetch_array($s3);
$c3 = mysql_num_rows($s3);
$sd3 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r3['name']."'");
$rd3 = mysql_fetch_array($sd3);
if($c3=="1") {
$slot3 = "images/sprites/".$rd3['picture'].".png";
$stats3 = "Level: ".$r3['level']."<br>EXP: ".$r3['exp']."";
$link3 = "<a href='battle.php?select=create&opp=".$r3['id']."'>Slot 3</a>";
}
else {
$slot3 = "images/maps/nothing.png";
$stats3 = "Empty";
$link3 = "Slot 3";
}

$s4 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='4'");
$r4 = mysql_fetch_array($s4);
$c4 = mysql_num_rows($s4);
$sd4 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r4['name']."'");
$rd4 = mysql_fetch_array($sd4);
if($c4=="1") {
$slot4 = "images/sprites/".$rd4['picture'].".png";
$stats4 = "Level: ".$r4['level']."<br>EXP: ".$r4['exp']."";
$link4 = "<a href='battle.php?select=create&opp=".$r4['id']."'>Slot 4</a>";
}
else {
$slot4 = "images/maps/nothing.png";
$stats4 = "Empty";
$link4 = "Slot 4";
}

$s5 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='5'");
$r5 = mysql_fetch_array($s5);
$c5 = mysql_num_rows($s5);
$sd5 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r5['name']."'");
$rd5 = mysql_fetch_array($sd5);
if($c5=="1") {
$slot5 = "images/sprites/".$rd5['picture'].".png";
$stats5 = "Level: ".$r5['level']."<br>EXP: ".$r5['exp']."";
$link5 = "<a href='battle.php?select=create&opp=".$r5['id']."'>Slot 5</a>";
}
else {
$slot5 = "images/maps/nothing.png";
$stats5 = "Empty";
$link5 = "Slot 5";
}

$s6 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='6'");
$r6 = mysql_fetch_array($s6);
$c6 = mysql_num_rows($s6);
$sd6 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r6['name']."'");
$rd6 = mysql_fetch_array($sd6);
if($c6=="1") {
$slot6 = "images/sprites/".$rd6['picture'].".png";
$stats6 = "Level: ".$r6['level']."<br>EXP: ".$r6['exp']."";
$link6 = "<a href='battle.php?select=create&opp=".$r6['id']."'>Slot 6</a>";
}
else {
$slot6 = "images/maps/nothing.png";
$stats6 = "Empty";
$link6 = "Slot 6";
}

$sb = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='box'");
$cb = mysql_num_rows($sb);

echo "<table width='90%' cellpadding='1' cellspacing='1' style='border: 1px solid black;' align='center'>
<tr><td width='90%' style='border: 1px solid black;' colspan='6'>".$result['name']."'s Profile</td></tr>
<tr><td width='90%' style='border: 1px solid black;' colspan='6'><img src=\"images/sprites/".$result['avatar'].".png\" alt='Avatar' /></td></tr>
<tr><td width='90%' style='border: 1px solid black;' colspan='6'><a href=\"trade.php?select=choose&id=".$result['id']."\">Trade with ".$result['name']."</a></td></tr>
<tr><td width='30%' style='border: 1px solid black;' colspan='2'>User ID</td><td width='60%' colspan='4' style='border: 1px solid black;'>#".$result['id']."</td></tr>
<tr><td width='30%' style='border: 1px solid black;' colspan='2'>User Email</td><td width='60%' style='border: 1px solid black;' colspan='4'>";
if($result['emailopt']=="Show") {
echo $result['email'];
}
else {
echo "<i>Hidden</i>";
}
echo "</td></tr>
<tr><td width='30%' colspan='2' style='border: 1px solid black;'>User Rank</td><td colspan='4' width='60%' style='border: 1px solid black;'>";
echo rank($result['rank']);
echo "</td></tr>
<tr><td width='90%' colspan='6' style='border: 1px solid black;'>User Signature</td></tr>
<tr><td width='90%' colspan='6' style='border: 1px solid black;'>";
echo parseBBCode($result['sig']);
echo "</td></tr>
<tr><td width='90%' colspan='6' style='border: 1px solid black;'>User's Party</td></tr>
<tr><td width='16%' colspan='1' style='border: 1px solid black;' onmouseover=\"gettip('$slot1')\" onmouseout=''>".$link1."</td><td width='16%' colspan='1' style='border: 1px solid black;' onmouseover=\"gettip('$slot2')\" onmouseout=''>".$link2."</td><td width='16%' colspan='1' style='border: 1px solid black;' onmouseover=\"gettip('$slot3')\" onmouseout=''>".$link3."</td><td width='16%' colspan='1' style='border: 1px solid black;' onmouseover=\"gettip('$slot4')\" onmouseout=''>".$link4."</td><td width='16%' colspan='1' style='border: 1px solid black;' onmouseover=\"gettip('$slot5')\" onmouseout=''>".$link5."</td><td width='16%' colspan='1' style='border: 1px solid black;' onmouseover=\"gettip('$slot6')\" onmouseout=''>".$link6."</td></tr>
<tr><td width='16%' colspan='1' style='border: 1px solid black;'>".$stats1."</td><td width='16%' colspan='1' style='border: 1px solid black;'>".$stats2."</td><td width='16%' colspan='1' style='border: 1px solid black;'>".$stats3."</td><td width='16%' colspan='1' style='border: 1px solid black;'>".$stats4."</td><td width='16%' colspan='1' style='border: 1px solid black;'>".$stats5."</td><td width='16%' colspan='1' style='border: 1px solid black;'>".$stats6."</td></tr>
<tr><td width='90%' colspan='6' style='border: 1px solid black;' id='tip' height='90'><font color='red'>Mouse over one of the slots to see which pokemon is there.</font></td></tr>
<tr><td width='100%' colspan='6' style='border: 1px solid black;'>User Box</td></tr>
<tr><td width='100%' colspan='6' style='border: 1px solid black;'>";
if($cb >= "1") {
while($rowb = mysql_fetch_array($sb)) {
$sdb = mysql_query("SELECT * FROM `data` WHERE `name`='".$rowb['name']."'");
$rdb = mysql_fetch_array($sdb);
echo "<a href='battle.php?select=create&opp=";
echo $rowb['id'];
echo "'><img src='images/sprites/icons/";
echo $rdb['icon'];
echo ".gif' alt='' onmouseover=\"Tip('";
echo $rdb['name'];
echo " - Level: ";
echo $rowb['level'];
echo "')\" onmouseout='UnTip()' /></a>";
}
}
else {
echo "No pokemon in box.";
}
echo "</td></tr></table>";
}
else {
echo "This user does not exist.";
}
require('stuff/bottom.php');
?>

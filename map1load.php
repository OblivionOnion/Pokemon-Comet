<?php
session_start();
require('stuff/connect.php');
require('stuff/functions.php');
$var = safe($_GET['id']);
$query = mysql_query("SELECT * FROM `map1` WHERE `id`='".$var."'");
$result = mysql_fetch_array($query);
?>
<script type='text/javascript'>
function loadlink(url)
{
     if (window.XMLHttpRequest)
     {
       xmlhttp=new XMLHttpRequest();
     }
     else
     {
       xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
     }
     xmlhttp.open("GET",url,false);
     xmlhttp.send(null);
     document.getElementById('load').innerHTML=xmlhttp.responseText;
}
</script>
<table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black';>
<tr><td width='90%' colspan='3' style='border: 1px solid black;'>
<?php
if($result['up']=="0") {
echo "<img src='images/maps/up.png' alt='up' />";
}
else {
?>
<a style='cursor: pointer;' onclick="loadlink('map1load.php?id=<?php echo $result['up']; ?>')"><img src='images/maps/up.png' alt='up' /></a>
<?php
}
?></td><td width='20%' style='border: 1px solid black;'  rowspan='3' width='100'>
<?php
$rand = rand(1,200);
if($rand=="76") {
$levrand = rand(1,10);
mysql_query("INSERT INTO `pokemon` (`name`, `type`, `owner`, `level`, `position`) VALUES ('Shiny Cranidos', 'Shiny', '".$_SESSION['name']."', '".$levrand."', '".$spot."')") or die(mysql_error());
echo "<img src='images/sprites/shiny/408.png' alt='find' /><br>You found something!";
}
elseif($rand=="152") {
$levrand = rand(1,10);
mysql_query("INSERT INTO `pokemon` (`name`, `type`, `owner`, `level`, `position`) VALUES ('Shiny Shieldon', 'Shiny', '".$_SESSION['name']."', '".$levrand."', '".$spot."')") or die(mysql_error());
echo "<img src='images/sprites/shiny/410.png' alt='find' /><br>You found something!";
}
else {
echo "<img src='images/maps/nothing.png' alt='Nothing' /><br>Nothing...";
}
?></td></tr>
<tr><td width='20%' colspan='1' style='border: 1px solid black;'>
<?php
if($result['left']=="0") {
echo "<img src='images/maps/left.png' alt='left' />";
}
else {
?><a style='cursor: pointer;' onclick="loadlink('map1load.php?id=<?php echo $result['left']; ?>')"><img src='images/maps/left.png' alt='left' /></a>
<?php
}
?></td>
<td width='50%' colspan='1' style='border: 1px solid black;' height='170' width='100'><?php
$var2 = $result['id'];
?><img src="images/maps/map.php?id=<?php echo $var2; ?>" alt='' />
</td><td width='20%' colspan='1' style='border: 1px solid black;'><?php
if($result['right']=="0") {
echo "<img src='images/maps/right.png' alt='right' />";
}
else {
?><a style='cursor: pointer;' onclick="loadlink('map1load.php?id=<?php echo $result['right']; ?>')"><img src='images/maps/right.png' alt='right' /></a>
<?php
}
?></td></tr>
<tr><td width='90%' colspan='3' style='border: 1px solid black;'>
<?php
if($result['down']=="0") {
echo "<img src='images/maps/down.png' alt='down' />";
}
else {
?><a style='cursor: pointer;' onclick="loadlink('map1load.php?id=<?php echo $result['down']; ?>')"><img src='images/maps/down.png' alt='down' /></a>
<?php
}
?></td></tr>
</table>

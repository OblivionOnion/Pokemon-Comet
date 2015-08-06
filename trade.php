<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
$var = safe($_GET['select']);
if($var=="create") {
if(isset($_POST['submit'])) {
$name = safe($_POST['search']);
$query1 = mysql_query("SELECT * FROM `users` WHERE `name`='".$name."'");
$result1 = mysql_fetch_array($query1); 
$check1 = mysql_num_rows($query1);
if($check1=="1") {
echo "Click <a href=\"?select=choose&id=".$result1['id']."\">here</a> to advance.";
}
else {
echo "This user does not exist.";
}
}
?>
<form action="?select=create" method="post">
Please enter the trainer's name in the box below.<br>
<input type='text' name='search' maxlength='30'><br>
<input type='submit' name='submit' value='Create Trade!'>
</form>
<?php
}
elseif($var=="choose") {
$var2 = safe($_GET['id']);
$query = mysql_query("SELECT * FROM `users` WHERE `id`='".$var2."'");
$result = mysql_fetch_array($query);
$check = mysql_num_rows($query);
$query1 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='box'");
$query2 = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$result2 = mysql_fetch_array($query2);
$check2 = mysql_num_rows($query2);
$query3 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result2['name']."' AND `position`='box'");
if(isset($_POST['submit'])) {
mysql_query("INSERT INTO `trades` (`yourid`, `otherid`) VALUES ('".$_SESSION['id']."', '".$result['id']."')") or die(mysql_error());
$que = mysql_query("SELECT * FROM `trades` WHERE `yourid`='".$_SESSION['id']."' ORDER BY `id` DESC LIMIT 1");
$res = mysql_fetch_array($que);
$yourpoke = $_POST['yourpoke'];
if(is_array($yourpoke)) {
while (list ($key, $val) = each ($yourpoke)) {
$checkpokey = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$val."'");
$res = mysql_fetch_array($checkpokey);
if($res['owner'] != $_SESSION['name']) {
echo "Not your pokemon";
require('stuff/bottom.php');
die();
}
else {
$ypoke = $val;
mysql_query("INSERT INTO `trade_poke` (`trade_id`, `poke_id`, `whos`) VALUES ('".$res['id']."', '".$ypoke."', 'yours')") or die(mysql_error());
mysql_query("UPDATE `pokemon` SET `position`='box' WHERE `id`='".$ypoke."'");
}
}
}
else {
echo "Nothing";
} 

$otherpoke = $_POST['otherpoke'];
if(is_array($otherpoke)) {
while (list ($key, $val) = each ($otherpoke)) {
$checkpokeo = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$val."'");
$res2 = mysql_fetch_array($checkpokeo);
if($res2['owner'] != $_SESSION['name']) {
echo "Not their pokemon";
require('require/bottom.php');
die();
}
else {
$opoke = $val;
mysql_query("INSERT INTO `trade_poke` (`trade_id`, `poke_id`, `whos`) VALUES ('".$res['id']."', '".$opoke."', 'theirs')") or die(mysql_error());
mysql_query("UPDATE `pokemon` SET `position`='box' WHERE `id`='".$opoke."'");
}
}
}
else {
echo "Nothing";
}

echo "Trade Successfully created!"; 
}
else {
?>
Enter the pokemon you want to trade. Hold CTRL to select multiple.
<form action="?select=choose&id=<?php echo $result['id']; ?>" method='post'><table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'><tr>
<td width='45%' colspan='1'><b>Your Pokemon</b><br>
<select name='yourpoke[]' size='10' multiple width='100'>
<option value='nothing'>Nothing</option>
<?php
while($row = mysql_fetch_array($query3)) {
echo "<option value=\"";
echo $row['id'];
echo "\">";
echo $row['name'];
echo "(Level: ";
echo $row['level'];
echo ")</option>";
}
?>
</select></td>
<td width='45%' colspan='1'><b><?php echo $result['name']; ?>'s Pokemon</b><br>
<select name='otherpoke[]' size='10' multiple width='100'>
<option value='nothing'>Nothing</option>
<?php
while($row = mysql_fetch_array($query1)) {
echo "<option value=\"";
echo $row['id'];
echo "\">";
echo $row['name'];
echo "(Level: ";
echo $row['level'];
echo ")</option>";
}
?>
</td></tr>
<tr><td width='90%' colspan='2'><input type='submit' name='submit' value='Create Trade!'></td></tr>
</table></form>
<?php
}
}
elseif($var=="pending") {
$query = mysql_query("SELECT * FROM `trades` WHERE `otherid`='".$_SESSION['id']."' AND `status`='pending'");
echo "Here you can view your pending trades.<br>
<table width='90%' cellspacing='1' cellpadding='1' align='center' style='border: 1px solid black;'>
<tr><th colspan='2' style='border: 1px solid black;'>Trades To You</th></tr>
<tr><td width='70%' style='border: 1px solid black;'>Sender</td><td width='20%' style='border: 1px solid black;'>View</td></tr>";
while($row = mysql_fetch_array($query)) {
$query2 = mysql_query("SELECT * FROM `users` WHERE `id`='".$row['yourid']."'");
$res2 = mysql_fetch_array($query2);
echo "<td width='70%' style='border: 1px solid black;'>";
echo $res2['name'];
echo "</td><td width='20%' style='border: 1px solid black;'><a href='?select=view&id=";
echo $row['id'];
echo "'>View Trade</a></td></tr>";
}
echo "</table>";
}
elseif($var=="view") {
$var3 = safe($_GET['id']);
$query = mysql_query("SELECT * FROM `trades` WHERE `id`='".$var3."'");
$res = mysql_fetch_array($query);
$check = mysql_num_rows($query);
if($res['otherid']==$_SESSION['id']) {
if($check=="1") {
if(isset($_POST['accept'])) {
$query2 = mysql_query("SELECT * FROM `trade_poke` WHERE `trade_id`='".$res['id']."' AND `whos`='theirs'");
$query3 = mysql_query("SELECT * FROM `trade_poke` WHERE `trade_id`='".$res['id']."' AND `whos`='yours'");
while($row = mysql_fetch_array($query2)) {
$poke1 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$row['poke_id']."'");
$poker1 = mysql_fetch_array($poke1);
$user1 = mysql_query("SELECT * FROM `users` WHERE `id`='".$res['yourid']."'");
$userr1 = mysql_fetch_array($user1);
$update1 = mysql_query("UPDATE `pokemon` SET `owner`='".$userr1['name']."' WHERE `id`='".$poker1['id']."'");
}
while($row2 = mysql_fetch_array($query3)) {
$poke1 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$row2['poke_id']."'");
$poker1 = mysql_fetch_array($poke1);
$user1 = mysql_query("SELECT * FROM `users` WHERE `id`='".$res['otherid']."'");
$userr1 = mysql_fetch_array($user1);
$update1 = mysql_query("UPDATE `pokemon` SET `owner`='".$userr1['name']."' WHERE `id`='".$poker1['id']."'");
}
echo "Trade Successfully Completed!";
mysql_query("UPDATE `trades` SET `status`='accepted' WHERE `id`='".$var3."'");
}
elseif(isset($_POST['decline'])) {
echo "Trade Successfully Declined!";
mysql_query("UPDATE `trades` SET `status`='declined' WHERE `id`='".$var3."'");
}
else {
$query2 = mysql_query("SELECT * FROM `trade_poke` WHERE `trade_id`='".$res['id']."' AND `whos`='theirs'");
echo "<form action='?select=view&id=".$var3."' method='post'><table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'>
<tr><th colspan='2' style='border: 1px solid black;'>Trade ID #".$var3."</th></tr>
<tr><td width='45%' style='border: 1px solid black;'>You Are Trading:<br>";
while($row = mysql_fetch_array($query2)) {
$poke1 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$row['poke_id']."'");
$res1 = mysql_fetch_array($poke1);
echo $res1['name'];
echo "(Level: ";
echo $res1['level'];
echo ")<br>";
}
echo "</td><td width='45%' style='border: 1px solid black;'>You Are Getting:<br>";
$query3 = mysql_query("SELECT * FROM `trade_poke` WHERE `trade_id`='".$res['id']."' AND `whos`='yours'");
while($row = mysql_fetch_array($query3)) {
$poke2 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$row['poke_id']."'");
$res2 = mysql_fetch_array($poke2);
echo $res2['name'];
echo "(Level: ";
echo $res2['level'];
echo ")<br>";
}
echo "</td></tr>
<tr><td width='45%' style='border: 1px solid black;'><input type='submit' name='accept' value='Accept!'></td><td width='45%' style='border: 1px solid black;'><input type='submit' name='decline' value='Decline!'></td></tr></table></form>";
}
}
else {
echo "This trade does not exist.";
}
}
else {
echo "This trade is not for you.";
}
}
else {
echo "None";
}
}
else {
echo "You are unallowed to view this page.";
}
require('stuff/bottom.php');
?>

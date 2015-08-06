<?php
require('stuff/top.php');
if(isset($_POST['submit'])) {
$search = safe($_POST['user']);
if($_POST['searchopt']=="id") {
$q1 = mysql_query("SELECT * FROM `users` WHERE `id`='".$search."'");
$c1 = mysql_num_rows($q1);
if($c1=="1") {
$r1 = mysql_fetch_array($q1);
echo "<script type='text/javascript'>
window.location = \"profile.php?id=".$r1['id']."\";
</script>";
}
else {
echo "This ID does not exist.<br><br>";
}
}
else {
$q2 = mysql_query("SELECT * FROM `users` WHERE `name`='".$search."'");
$c2 = mysql_num_rows($q2);
if($c2=="1") {
$r2 = mysql_fetch_array($q2);
echo "<script type='text/javascript'>
window.location = \"profile.php?id=".$r2['id']."\";
</script>";
}
else {
echo "This username does not exist.<br><br>";
}
}
}
?>
<form action="<?php echo safe($_SERVER['PHP_SELF']); ?>" method='post'><table width='90%' align='center' style='border: 1px solid black;'>
<tr><th width='30%' style='border: 1px solid black;'>Search Option</th><th width='60%' style='border: 1px solid black;'>Search</th></tr>
<tr><td width='30%' style='border: 1px solid black;'>
<select name='searchopt'>
<option value='id' selected='selected'>User ID</option>
<option value='name'>Username</otion>
</select></td><td width='60%' style='border: 1px solid black;'>
<input type='text' name='user' maxlength='255'></td></tr>
<tr><td colspan='2' width='90%' style='border: 1px solid black;'>
<input type='submit' name='submit' value='Find!'></td></tr></table>
</form>
<?php
require('stuff/bottom.php');
?>

<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
if(isset($_POST['submit'])) {
$post = safe($_POST['avy']);
if($post < '1' || $post > '493') {
echo "Please choose a legit avatar.";
}
else {
$avy ="normal/".$post."";
$updateavy = mysql_query("UPDATE `users` SET `avatar`='".$avy."' WHERE `id`='".$_SESSION['id']."'");
echo "Avatar successfully changed!";
}
}
else {
?>
Here you can change your avatar. All Pokemon are normal.<br><br>
<form action="<?php echo safe($_SERVER['PHP_SELF']); ?>" method='post'><table width='90%' align='center' style='border: 1px solid black;'><tr>
<td width='45%' style='border: 1px solid black;'><img src='images/sprites/normal/001.png' alt='001' id="trainer_img" /></td><td width='45%' style='border: 1px solid black;'>
<select name='avy' onchange="ShowImage();" size='15'>
<?php
$i=1;
while($i<=493) {
  echo "<option value=\"";  if($i<='9') {
  echo "00";
  echo $i;
  }
  elseif($i<="99") {
  echo "0";
  echo $i;
  }
  else {
  echo $i;
  }
  echo "\">";
  if($i<='9') {
  echo "00";
  echo $i;
  }
  elseif($i<="99") {
  echo "0";
  echo $i;
  }
  else {
  echo $i;
  }
  echo "</option>";
  $i++;
  }
?>
</select>
</td></tr>
<tr><td width='90%' style='border: 1px solid black;' colspan='2'><input type='submit' name='submit' value='Change!'></td></tr></table></form>
<?php
}
}
else {
echo "You are unallowed to view this page.";
}
require('stuff/bottom.php');
?>

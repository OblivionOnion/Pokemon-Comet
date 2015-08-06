<?php
if(isset($_POST['mmk'])) {
$numbers = $_POST['numbers'];
echo "You selected:<br>";
if(is_array($numbers)) {
while (list ($key, $val) = each ($numbers)) {
echo $val;
echo "<br>";
}
}
}
else {
?>
<form action='test.php' method='post'>
<select name='numbers[]' size='20' multiple>
<?php
$i = 1;
while($i < 30) {
echo "<option value='".$i."'>".$i."</option>";
$i++;
}
?>
</select>
<input type='submit' name='mmk' value='Go'>
</form>
<?php
}
?>

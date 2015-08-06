<?php
require('stuff/top.php');
$q = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$result = mysql_fetch_array($q);

$s1 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='1'");
$r1 = mysql_fetch_array($s1);
$c1 = mysql_num_rows($s1);
$sd1 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r1['name']."'");
$rd1 = mysql_fetch_array($sd1);
if($c1=="1") {
$slot1 = "<img src='images/sprites/".$rd1['picture'].".png' id='recordsArray_".$r1['id']."' />";
}
else {
$slot1 = "";
}

$s2 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='2'");
$r2 = mysql_fetch_array($s2);
$c2 = mysql_num_rows($s2);
$sd2 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r2['name']."'");
$rd2 = mysql_fetch_array($sd2);
if($c2=="1") {
$slot2 = "<img src='images/sprites/".$rd2['picture'].".png' id=\"recordsArray_".$r2['id']."\" />";
}
else {
$slot2 = "";
}

$s3 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='3'");
$r3 = mysql_fetch_array($s3);
$c3 = mysql_num_rows($s3);
$sd3 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r3['name']."'");
$rd3 = mysql_fetch_array($sd3);
if($c3=="1") {
$slot3 = "<img src='images/sprites/".$rd3['picture'].".png' id=\"recordsArray_".$r3['id']."\" />";
}
else {
$slot3 = "";
}

$s4 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='4'");
$r4 = mysql_fetch_array($s4);
$c4 = mysql_num_rows($s4);
$sd4 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r4['name']."'");
$rd4 = mysql_fetch_array($sd4);
if($c4=="1") {
$slot4 = "<img src='images/sprites/".$rd4['picture'].".png' id=\"recordsArray_".$r4['id']."\" />";
}
else {
$slot4 = "";
}

$s5 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='5'");
$r5 = mysql_fetch_array($s5);
$c5 = mysql_num_rows($s5);
$sd5 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r5['name']."'");
$rd5 = mysql_fetch_array($sd5);
if($c5=="1") {
$slot5 = "<img src='images/sprites/".$rd5['picture'].".png' id=\"recordsArray_".$r5['id']."\" />";
}
else {
$slot5 = "";
}

$s6 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$result['name']."' AND `position`='6'");
$r6 = mysql_fetch_array($s6);
$c6 = mysql_num_rows($s6);
$sd6 = mysql_query("SELECT * FROM `data` WHERE `name`='".$r6['name']."'");
$rd6 = mysql_fetch_array($sd6);
if($c6=="1") {
$slot6 = "<img src='images/sprites/".$rd6['picture'].".png' id=\"recordsArray_".$r6['id']."\" />";
}
else {
$slot6 = "";
}
?>
	<script type="text/javascript">	
$(document).ready(function(){ 
						   
	$(function() {
		$("#contentLeft").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("updatedb.php", order, function(theResponse){
			}); 															 
		}								  
		});
	});

});
	</script>
<style type='text/css'>
#contentLeft {
	float: left;
        text-align: center;
}

#contentLeft li {
	list-style: none;
	border: #000000 solid 1px;
	color:#fff;
}

#contentBox {
border: 1px solid black;
float: left;
}
</style>


Here you can order your party, and only that. Drag and Drop pokemon to the spot you want.<br>
1 --> 6<br><br>
<div id="contentLeft">
<?php echo $slot1; ?>
<?php echo $slot2; ?>
<?php echo $slot3; ?>
<?php echo $slot4; ?>
<?php echo $slot5; ?>
<?php echo $slot6; ?>
</div>
<?php
require('stuff/bottom.php');
?>

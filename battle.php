<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
$var = safe($_GET['select']);
if($var=="create") {
$opp = safe($_GET['opp']);
$you1 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='1'");
$res1 = mysql_fetch_array($you1);
$check1 = mysql_num_rows($you1);
$youdata1 = mysql_query("SELECT * FROM `data` WHERE `name`='".$res1['name']."'");
$resdata1 = mysql_fetch_array($youdata1);
$opp1 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$opp."'");
$res2 = mysql_fetch_array($opp1);
$check2 = mysql_num_rows($opp1);
$oppdata2 = mysql_query("SELECT * FROM `data` WHERE `name`='".$res2['name']."'");
$resdata2 = mysql_fetch_array($oppdata2);
if($check1=="0") {
echo "You do not have a pokemon in slot 1.";
}
elseif($check2=="0") {
echo "This pokemon does not exist.";
}
else {
$yhp = ceil($resdata1['hp'] * $res1['level'] / 10);
$yatt = ceil($resdata1['attack'] * $res1['level'] / 10);
$ydef = ceil($resdata1['defense'] * $res1['level'] / 10);
$ysatt = ceil($resdata1['s_attack'] * $res1['level'] / 10);
$ysdef = ceil($resdata1['s_defense'] * $res1['level'] / 10);
$yspd = ceil($resdata1['speed'] * $res1['level'] / 10);
$ohp = ceil($resdata2['hp'] * $res2['level'] / 10);
$oatt = ceil($resdata2['attack'] * $res2['level'] / 10);
$odef = ceil($resdata2['defense'] * $res2['level'] / 10);
$osatt = ceil($resdata2['s_attack'] * $res2['level'] / 10);
$osdef = ceil($resdata2['s_defense'] * $res2['level'] / 10);
$ospd = ceil($resdata2['speed'] * $res2['level'] / 10);
mysql_query("INSERT INTO `battles` (`yourid`, `otherid`, `othername`, `yourpid`, `otherpid`, `yourlv`, `otherlv`, `yourmaxhp`, `othermaxhp`, `yourchp`, `otherchp`, `youratt`, `otheratt`, `yourdef`, `otherdef`, `yourspatt`, `otherspatt`, `yourspdef`, `otherspdef`, `yourspd`, `otherspd`) VALUES ('".$_SESSION['id']."', '".$res2['id']."', '".$res2['owner']."', '".$res1['id']."', '".$opp."', '".$res1['level']."', '".$res2['level']."', '".$yhp."', '".$ohp."', '".$yhp."', '".$ohp."', '".$yatt."', '".$oatt."', '".$ydef."', '".$odef."', '".$ysatt."', '".$osatt."', '".$ysdef."', '".$osdef."', '".$yspd."', '".$ospd."')") or die(mysql_error());
$battle = mysql_query("SELECT * FROM `battles` WHERE `yourid`='".$_SESSION['id']."' ORDER BY `id` DESC LIMIT 1");
$sess = mysql_fetch_array($battle);
$_SESSION['battle'] = $sess['id'];
require('stuff/bottom.php');
echo "Redirecting....
<script type='text/javascript'>
window.location = 'battle.php?select=battle'
</script>";
die();
}
}
elseif($var=="battle") {
if(isset($_SESSION['battle'])) {
$q = mysql_query("SELECT * FROM `battles` WHERE `id`='".$_SESSION['battle']."'");
$r = mysql_fetch_array($q);
$you1 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='1'");
$res1 = mysql_fetch_array($you1);
$youdata1 = mysql_query("SELECT * FROM `data` WHERE `name`='".$res1['name']."'");
$resdata1 = mysql_fetch_array($youdata1);
$opp1 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$r['otherpid']."'");
$res2 = mysql_fetch_array($opp1);
$check2 = mysql_num_rows($opp1);
$oppdata2 = mysql_query("SELECT * FROM `data` WHERE `name`='".$res2['name']."'");
$resdata2 = mysql_fetch_array($oppdata2);

if(isset($_POST['attack'])) {
if($_POST['moves']=="move1") {
$ymove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res1['move1']."'");
$resmove1 = mysql_fetch_array($ymove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move1 = "Your move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil(($r['youratt'] * $resmove1['power']) / $r['otherdef']);
$curhptst = $r['otherchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhptst."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$physdmg." damage to ".$res2['name'].".";
}
else {
$specdmg = ceil(($r['yourspatt'] * $resmove1['power']) / $r['otherspdef']);
$curhp = $r['otherchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$specdmg." damage to ".$res2['name'].".";
}
}
$randnum = rand(1,4);
if($randnum=="1") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move1']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhp = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="2") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move2']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="3") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move3']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
else {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move4']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
}
elseif($_POST['moves']=="move2") {
$ymove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res1['move2']."'");
$resmove1 = mysql_fetch_array($ymove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move1 = "Your move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['youratt'] * $resmove1['power'] / $r['otherdef']);
$curhptst = $r['otherchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhptst."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$physdmg." damage to ".$res2['name'].".";
}
else {
$specdmg = ceil($r['yourspatt'] * $resmove1['power'] / $r['otherspdef']);
$curhp = $r['otherchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$specdmg." damage to ".$res2['name'].".";
}
}
$randnum = rand(1,4);
if($randnum=="1") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move1']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhp = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="2") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move2']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="3") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move3']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
else {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move4']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
}
elseif($_POST['moves']=="move3") {
$ymove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res1['move3']."'");
$resmove1 = mysql_fetch_array($ymove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move1 = "Your move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['youratt'] * $resmove1['power'] / $r['otherdef']);
$curhptst = $r['otherchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhptst."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$physdmg." damage to ".$res2['name'].".";
}
else {
$specdmg = ceil($r['yourspatt'] * $resmove1['power'] / $r['otherspdef']);
$curhp = $r['otherchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$specdmg." damage to ".$res2['name'].".";
}
}
$randnum = rand(1,4);
if($randnum=="1") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move1']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhp = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="2") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move2']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="3") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move3']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
else {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move4']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
}
else {
$ymove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res1['move4']."'");
$resmove1 = mysql_fetch_array($ymove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move1 = "Your move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['youratt'] * $resmove1['power'] / $r['otherdef']);
$curhptst = $r['otherchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhptst."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$physdmg." damage to ".$res2['name'].".";
}
else {
$specdmg = ceil($r['yourspatt'] * $resmove1['power'] / $r['otherspdef']);
$curhp = $r['otherchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `otherchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move1 = "You used ".$resmove1['name']." and it did ".$specdmg." damage to ".$res2['name'].".";
}
}
$randnum = rand(1,4);
if($randnum=="1") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move1']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhp = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="2") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move2']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
elseif($randnum=="3") {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move3']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
else {
$omove1 = mysql_query("SELECT * FROM `moves` WHERE `name`='".$res2['move4']."'");
$resmove1 = mysql_fetch_array($omove1);
$accmove1 = rand(1,100);
$acc = $resmove1['accuracy'];
if($accmove1 > $acc) {
$move2 = "Their move missed.";
}
else {
if($resmove1['type']=="Physicial") {
$physdmg = ceil($r['otheratt'] * $resmove1['power'] / $r['yourdef']);
$curhp = $r['yourchp']-$physdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhp."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$physdmg." damage to your ".$res1['name']."";
}
else {
$specdmg = ceil($r['otherspatt'] * $resmove1['power'] / $r['yourspdef']);
$curhptst2 = $r['yourchp']-$specdmg;
$updateohp = mysql_query("UPDATE `battles` SET `yourchp`='".$curhptst2."' WHERE `id`='".$_SESSION['battle']."'") or die(mysql_error());
$move2 = "".$res2['name']." used ".$resmove1['name']." and it did ".$specdmg." damage to your ".$res1['name']."";
}
}
}
}
}
$q2 = mysql_query("SELECT * FROM `battles` WHERE `id`='".$_SESSION['battle']."'");
$r2 = mysql_fetch_array($q2);
if($r2['yourchp'] <= "0") {
$yourhp = "0";
}
else {
$yourhp = ceil($r2['yourchp'] / $r2['yourmaxhp'] * 100);
}
if($r2['otherchp'] <= "0") {
$otherhp = "0";
}
else {
$otherhp = ceil($r2['otherchp'] / $r2['othermaxhp'] * 100);
}
echo "<table border='0' width='90%' align='center' style='text-align: center;' cellpadding='1' cellspacing='1' valign='top'>
<tr><td colspan='1' width='45%'><div id='battlename'>Your ".$res1['name']."</div></td><td colspan='1'  width='45%'><div id='battlename'>".$r['othername']."'s ".$res2['name']."</div></td></tr>
<tr><td colspan='1'><img src='images/sprites/".$resdata1['picture'].".png' alt='' /></td><td colspan='1'><img src='images/sprites/".$resdata2['picture'].".png' alt='' /></td></tr>
<tr><td width='45%' colspan='1' style='text-align: center' align='center'><center><div id='yourhp'><img src='images/layout/hpbar.png' style='width: ".$yourhp."px; height: 10px; text-align: left;' alt='hp' /></div></center></td><td width='45%' colspan='1' style='text-align: center' align='center'><center><div id='otherhp' align='center'><img src='images/layout/hpbar.png' style='width: ".$otherhp."px; height: 10px; text-align: left;' alt='hp' /></div></center></td></tr>
<tr><td width='45%' colspan='2'>".$move1."<br>".$move2."</td></tr>
<tr><td width='45%' colspan='2'>";
if($r2['yourchp'] <= "0") {
echo "You lose.<br><a href='?select=create&opp=".$r['otherpid']."'>Restart Battle?</a>";
unset($_SESSION['battle']);
}
elseif($r2['otherchp'] <= "0") {
echo "You win.<br>";
$exp = ceil($r2['othermaxhp'] * 10 / 7);
$gain = $res1['exp'] + $exp;
$update = mysql_query("UPDATE `pokemon` SET `exp`='".$gain."' WHERE `id`='".$r2['yourpid']."'");
$q3 = mysql_query("SELECT * FROM `pokemon` WHERE `id`='".$r2['yourpid']."'");
$r3 = mysql_fetch_array($q3);
$lev = $r3['level']+1;
$exp2 = $lev*$lev*$lev;
if($r3['exp'] >= $exp2) {
$updatepoke = mysql_query("UPDATE `pokemon` SET `level`='".$lev."' WHERE `id`='".$r3['id']."'");
echo "Your pokemon has leveled up!";
}
else {
echo "Your pokemon has gained ".$exp." experience points.";
}
echo "<br><a href='?select=create&opp=".$r['otherpid']."'>Restart Battle?</a>";
unset($_SESSION['battle']);
}
else {
echo "<form action='?select=battle' method='post'>
<select name='moves'>
<option value='move1'>".$res1['move1']."</option>
<option value='move2'>".$res1['move2']."</option>
<option value='move3'>".$res1['move3']."</option>
<option value='move4'>".$res1['move4']."</option>
</select><br>
<input type='submit' name='attack' value='Attack!'>
</form>";
}
echo "</td></tr>
</table>";
}
else {
echo "Please create a Battle first.";
}
}
else {
echo "Does not exist.";
}
}
else {
echo "Please login.";
}
require('stuff/bottom.php');
?>

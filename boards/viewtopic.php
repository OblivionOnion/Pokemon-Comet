<?php
require('require/top.php');
if(isset($_SESSION['id'])) {
$var = safe($_GET['id']);
$q1 = mysql_query("SELECT * FROM `posts` WHERE `id`='".$var."' AND `type`='topic'");
$r1 = mysql_fetch_array($q1);
$c1 = mysql_num_rows($q1);
if($c1=="1") {
$q2 = mysql_query("SELECT * FROM `users` WHERE `name`='".$r1['poster']."'");
$r2 = mysql_fetch_array($q2);
$q5 = mysql_query("SELECT * FROM `forums` WHERE `id`='".$r1['forum']."'");
$r5 = mysql_fetch_array($q5);
$views = $r1['views'];
$update = $views+1;
$query = mysql_query("UPDATE `posts` SET `views`='".$update."' WHERE `id`='".$r1['id']."'");
echo "<table width='98%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black; text-align: left;'>
<tr><td width='100%' style='border: 1px solid black;' colspan='2'><a href='../boards'>Index</a> --> <a href='../boards/viewforum.php?id=".$r1['forum']."'>".$r5['name']."</a> --> ".$r1['title']."</td></tr>
<tr><td width='100%' style='border: 1px solid black;' colspan='2'>Topic: ".$r1['title']."</td></tr>
<tr><th width='30%' style='border: 1px solid black;'>User Info</th><th width='60%' style='border: 1px solid black;'>Post</th></tr>
<tr><td width='30%' style='border: 1px solid black;'><a href='../profile.php?id=".$r2['id']."'><b>".$r2['name']."</b></a><br>";
echo rank($r2['rank']);
echo "<br><img src='../images/sprites/".$r2['avatar'].".png' alt='avy' /></td><td width='60%' valign='top' style='border: 1px solid black; text-align: left;'>";
echo parseBBCode($r1['post']);
echo "<br><br>______________<br>";
echo parseBBCode($r2['sig']);
echo "</td></tr></table><br><br>";
$q3 = mysql_query("SELECT * FROM `posts` WHERE `type`='post' AND `topic`='".$r1['id']."'");
while($row = mysql_fetch_array($q3)) {
$q4 = mysql_query("SELECT * FROM `users` WHERE `name`='".$row['poster']."'");
$r4 = mysql_fetch_array($q4);
echo "<table width='98%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black; text-align: left;'>
<tr><th width='30%' style='border: 1px solid black;'>User Info</th><th width='60%' style='border: 1px solid black;'>Post</th></tr>
<tr><td width='30%' style='border: 1px solid black;'><a href='../profile.php?id=".$r4['id']."'><b>".$r4['name']."</b></a><br>";
echo rank($r4['rank']);
echo "<br><img src='../images/sprites/".$r4['avatar'].".png' alt='avy' /></td><td width='60%' valign='top' style='border: 1px solid black; text-align: left;'>";
echo parseBBCode($row['post']);
echo "</td></tr></table><br><br>";
}
if(isset($_POST['submit'])) {
$comment = safe($_POST['comment']);
if($comment=='') {
echo "Please enter a reply.";
}
else {
mysql_query("INSERT INTO `posts` (`poster`, `post`, `type`, `topic`, `forum`) VALUES ('".$_SESSION['name']."', '".$comment."', 'post', '".$r1['id']."', '".$r5['id']."')") or die(mysql_error());
$time = time();
mysql_query("UPDATE `posts` SET `lastpost`='".$time."' WHERE `id`='".$var."'");
echo "Reply posted!";
}
}
else {
?>
Enter your comment below!<br>
<form name="news_post" action="viewtopic.php?id=<?php echo $var; ?>" method="post"> 
<img src='../images/smilies/smile.png' alt=':)' onclick="document.forms.news_post.comment.value += ':)'" class='comment' />
<img src='../images/smilies/sad.png' alt=':(' onclick="document.forms.news_post.comment.value += ':('" class='comment' />
<img src='../images/smilies/mad.png' alt=':@' onclick="document.forms.news_post.comment.value += ':@'" class='comment' />
<img src='../images/smilies/yikes.png' alt=':O' onclick="document.forms.news_post.comment.value += ':O'" class='comment' />
<img src='../images/smilies/wink.png' alt=';)' onclick="document.forms.news_post.comment.value += ';)'" class='comment' />
<img src='../images/smilies/big_smile.png' alt=':D' onclick="document.forms.news_post.comment.value += ':D'" class='comment' />
<img src='../images/smilies/lol.png' alt='8D' onclick="document.forms.news_post.comment.value += '8D'" class='comment' />
<img src='../images/smilies/hmm.png' alt=':/' onclick="document.forms.news_post.comment.value += ':?'" class='comment' />
<img src='../images/smilies/tongue.png' alt=':P' onclick="document.forms.news_post.comment.value += ':P'" class='comment' /><br>
<textarea cols="50" rows="10" name="comment" maxlength='255'></textarea><br /> 
<input type="submit" name="submit" value="Post!" /> 
</form> 
<?php
}
}
else {
echo "This topic does not exist.";
}
}
else {
echo "Please login first.";
}
require('require/bottom.php');
?>

<?php
require('stuff/top.php');
if(isset($_SESSION['id'])) {
$var = safe($_GET['select']);
if($var=="news") {
$query = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
$result = mysql_fetch_array($query);
$query2 = mysql_query("SELECT * FROM `comments` WHERE `news_id`='".$result['id']."'");
$check2 = mysql_num_rows($query2);
$avy = $result['avatar'];
echo "Here you can view the current news.<br><table border='1' width='90%' style='border: 1px solid black;' cellpadding='1' cellspacing='1' align='center'>
<tr><td width='90%' style='border: 1px solid black;' colspan='2'>Title: ".$result['title']."</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Avatar</td><td width='60%' style='border: 1px solid black;'>News Post</td></tr>
<tr><td width='30%' style='border: 1px solid black;'><img src='images/sprites/";
echo $avy;
echo ".png' alt='Avatar' /></td><td width='60%' style='border: 1px solid black;'>";
echo parseBBCode($result['post']);
echo "</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Posted By</td><td width='60%' style='border: 1px solid black;'>".$result['poster']."</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Date Posted</td><td width='60%' style='border: 1px solid black;'>".$result['date']."th</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Time Posted</td><td width='60%' style='border: 1px solid black;'>".$result['time']."</td></tr>
<tr><td width='90%' style='border: 1px solid black;' colspan='2'><a href='?select=comments'>News Comments (x".$check2.")</a></td></tr>
</table>";
}
elseif($var=="edit") {
$var2 = safe($_GET['id']);
$query3 = mysql_query("SELECT * FROM `comments` WHERE `id`='".$var2."'");
$result3 = mysql_fetch_array($query3);
$idname = $result3['id'];
if(isset($_POST['submit'])) {
$comment = safe($_POST['comment']);
$update = mysql_query("UPDATE `comments` SET `comment`=\"".$comment."\" WHERE `id`='".$var2."'") or die(mysql_error());
echo "Your comment has been edited successfully.";
}
else {
if($result3['poster']==$_SESSION['name']) {
echo "Here you can edit your news comments.<br><br>
<form name='news_post' action=\"?select=edit&id=";
echo $idname;
echo"\" method='post'>
<img src='images/smilies/smile.png' alt=':)' onclick=\"document.forms.news_post.comment.value += ':)'\" class='comment' />
<img src='images/smilies/sad.png' alt=':(' onclick=\"document.forms.news_post.comment.value += ':('\" class='comment' />
<img src='images/smilies/mad.png' alt=':@' onclick=\"document.forms.news_post.comment.value += ':@'\" class='comment' />
<img src='images/smilies/yikes.png' alt=':O' onclick=\"document.forms.news_post.comment.value += ':O'\" class='comment' />
<img src='images/smilies/wink.png' alt=';)' onclick=\"document.forms.news_post.comment.value += ';)'\" class='comment' />
<img src='images/smilies/big_smile.png' alt=':D' onclick=\"document.forms.news_post.comment.value += ':D'\" class='comment' />
<img src='images/smilies/lol.png' alt='8D' onclick=\"document.forms.news_post.comment.value += '8D'\" class='comment' />
<img src='images/smilies/hmm.png' alt=':/' onclick=\"document.forms.news_post.comment.value += ':/'\" class='comment' />
<img src='images/smilies/tongue.png' alt=':P' onclick=\"document.forms.news_post.comment.value += ':P'\" class='comment' /><br>
<textarea name='comment' rows='10' cols='50'>".$result3['comment']."</textarea><br>
<input type='submit' name='submit' value='Edit Comment!'></form>";
}
else {
echo "This is not your news comment.";
}
}
}
elseif($var=="post") {
$query = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$res = mysql_fetch_array($query);
if($res['rank'] != "Administrator" && $res['rank'] != "Moderator") {
echo "You are unallowed to view this page.";
}
else {
if(isset($_POST['submit'])) {
$title = safe($_POST['title']);
$avatar = safe($_POST['avatar']);
$comment = safe($_POST['comment']);
$poster = $_SESSION['name'];
$time = date("g:i A");
$date = date("F j");
mysql_query("INSERT INTO `news` (`title`, `avatar`, `post`, `poster`, `time`, `date`) VALUES ('".$title."', '".$avatar."', \"".$comment."\", '".$poster."', '".$time."', '".$date."')") or die(mysql_error());
echo "News Posted.";
}
else {
echo "<form action='?select=post' name='news_post' method='post'>
<table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'>
<tr><td width='40%' colspan='1' style='border: 1px solid black;'><b>Title:</b><br>
<input type='text' name='title' maxlength='25'></td><td width='50%' style='border: 1px solid black;' rowspan='2'><b>Comment:</b><br>
<img src='images/smilies/smile.png' alt=':)' onclick=\"document.forms.news_post.comment.value += ':)'\" class='comment' />
<img src='images/smilies/sad.png' alt=':(' onclick=\"document.forms.news_post.comment.value += ':('\" class='comment' />
<img src='images/smilies/mad.png' alt=':@' onclick=\"document.forms.news_post.comment.value += ':@'\" class='comment' />
<img src='images/smilies/yikes.png' alt=':O' onclick=\"document.forms.news_post.comment.value += ':O'\" class='comment' />
<img src='images/smilies/wink.png' alt=';)' onclick=\"document.forms.news_post.comment.value += ';)'\" class='comment' />
<img src='images/smilies/big_smile.png' alt=':D' onclick=\"document.forms.news_post.comment.value += ':D'\" class='comment' />
<img src='images/smilies/lol.png' alt='8D' onclick=\"document.forms.news_post.comment.value += '8D'\" class='comment' />
<img src='images/smilies/hmm.png' alt=':/' onclick=\"document.forms.news_post.comment.value += ':/'\" class='comment' />
<img src='images/smilies/tongue.png' alt=':P' onclick=\"document.forms.news_post.comment.value += ':P'\" class='comment' /><br>
<textarea name='comment' rows='10' cols='35'></textarea></td></tr>
<tr><td width='40%' colspan='1' style='border: 1px solid black;'><b>Avatar:</b><br>
<input type='text' name='avatar' maxlength='25'></td></tr>
<tr><td width='90%' colspan='2' style='border: 1px solid black;'><input type='submit' name='submit' value='Post!'></td></tr>
</table></form>";
}
}
}
elseif($var=="editnews") {
$query = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$res = mysql_fetch_array($query);
$query2 = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
$res2 = mysql_fetch_array($query2);
if($res['rank'] != "Administrator" && $res['rank'] != "Moderator") {
echo "You are unallowed to view this page.";
}
else {
if(isset($_POST['submit'])) {
$title = safe($_POST['title']);
$avatar = safe($_POST['avatar']);
$comment = safe($_POST['comment']);
$poster = $_SESSION['name'];
$time = date("g:i A");
$date = date("F j");
mysql_query("UPDATE `news` SET `title`='".$title."', `avatar`='".$avatar."', `post`=\"".$comment."\" WHERE `id`='".$res2['id']."'");
echo "News Edited.";
}
else {
echo "<form action='?select=editnews' name='news_post' method='post'>
<table width='90%' cellpadding='1' cellspacing='1' align='center' style='border: 1px solid black;'>
<tr><td width='40%' colspan='1' style='border: 1px solid black;'><b>Title:</b><br>
<input type='text' name='title' maxlength='25' value=\"".$res2['title']."\"></td><td width='50%' style='border: 1px solid black;' rowspan='2'><b>Comment:</b><br>
<img src='images/smilies/smile.png' alt=':)' onclick=\"document.forms.news_post.comment.value += ':)'\" class='comment' />
<img src='images/smilies/sad.png' alt=':(' onclick=\"document.forms.news_post.comment.value += ':('\" class='comment' />
<img src='images/smilies/mad.png' alt=':@' onclick=\"document.forms.news_post.comment.value += ':@'\" class='comment' />
<img src='images/smilies/yikes.png' alt=':O' onclick=\"document.forms.news_post.comment.value += ':O'\" class='comment' />
<img src='images/smilies/wink.png' alt=';)' onclick=\"document.forms.news_post.comment.value += ';)'\" class='comment' />
<img src='images/smilies/big_smile.png' alt=':D' onclick=\"document.forms.news_post.comment.value += ':D'\" class='comment' />
<img src='images/smilies/lol.png' alt='8D' onclick=\"document.forms.news_post.comment.value += '8D'\" class='comment' />
<img src='images/smilies/hmm.png' alt=':/' onclick=\"document.forms.news_post.comment.value += ':/'\" class='comment' />
<img src='images/smilies/tongue.png' alt=':P' onclick=\"document.forms.news_post.comment.value += ':P'\" class='comment' /><br>
<textarea name='comment' rows='10' cols='35'>".$res2['post']."</textarea></td></tr>
<tr><td width='40%' colspan='1' style='border: 1px solid black;'><b>Avatar:</b><br>
<input type='text' name='avatar' maxlength='25' value=\"".$res2['avatar']."\"></td></tr>
<tr><td width='90%' colspan='2' style='border: 1px solid black;'><input type='submit' name='submit' value='Post!'></td></tr>
</table></form>";
}
}
}
elseif($var=="comments") {
$query = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
$result = mysql_fetch_array($query);
$query2 = mysql_query("SELECT * FROM `comments` WHERE `news_id`='".$result['id']."' ORDER BY `id` DESC");
$check2 = mysql_num_rows($query2);
$avy = $result['avatar'];
echo "Here you can view the current news.<br><table border='1' width='90%' style='border: 1px solid black;' cellpadding='1' cellspacing='1' align='center'>
<tr><td width='90%' style='border: 1px solid black;' colspan='2'>Title: ".$result['title']."</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Avatar</td><td width='60%' style='border: 1px solid black;'>News Post</td></tr>
<tr><td width='30%' style='border: 1px solid black;'><img src='images/sprites/";
echo $avy;
echo ".png' alt='Avatar' /></td><td width='60%' style='border: 1px solid black;'>";
echo parseBBCode($result['post']);
echo "</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Posted By</td><td width='60%' style='border: 1px solid black;'>".$result['poster']."</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Date Posted</td><td width='60%' style='border: 1px solid black;'>".$result['date']."th</td></tr>
<tr><td width='30%' style='border: 1px solid black;'>Time Posted</td><td width='60%' style='border: 1px solid black;'>".$result['time']."</td></tr>
<tr><td width='90%' style='border: 1px solid black;' colspan='2'><a href=''>News Comments (x".$check2.")</a></td></tr>
</table><br>";
echo "<br><div id='load'><a style='cursor: pointer;' onclick=\"loadXMLDoc('postcomment.php');\">Post a Comment</a></div><br>";
while($row = mysql_fetch_array($query2)) {
echo "<table border='1' width='90%' cellpadding='1' cellspacing='1' style='border: 1px solid black;' align='center'>
<tr><td width='30%' style='border: 1px solid black;'>Post ID: #";
echo $row['id'];
echo "</td><td width='60%' style='border: 1px solid black;'>Posted By: ";
echo $row['poster'];
echo "(";
echo rank($row['rank']);
echo ")</td></tr>";
if($row['poster']==$_SESSION['name']) {
echo "<tr><td width='90%' style='border: 1px solid black;' colspan='2'><a href=\"?select=edit&id=".$row['id']."\">Edit Comment</a></td></tr>";
}
else {
echo "";
}
echo "<tr><td width='30%' style='border: 1px solid black;'><img src='images/sprites/";
echo $row['avatar'];
echo ".png' alt='Post Avatar' /></td><td width='60%' style='border: 1px solid black;'>";
echo parseBBCode($row['comment']);
echo "</td></tr></table><br>";
}
}
else {
}
}
else {
echo "You are unallowed to view this page.";
}
require('stuff/bottom.php');
?>

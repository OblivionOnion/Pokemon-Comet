<?php
session_start();
require('stuff/connect.php');
require('stuff/functions.php');
if(isset($_POST['submit'])) {
if(isset($_SESSION['id'])) {
$query = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1");
$result = mysql_fetch_array($query);
$query2 = mysql_query("SELECT * FROM `comments` WHERE `news_id`='".$result['id']."' ORDER BY `id` DESC LIMIT 1");
$check2 = mysql_num_rows($query2);
$result2 = mysql_fetch_array($query2);
if($result2['poster']==$_SESSION['name']) {
echo "You are not allowed to post twice. Click <a href='news.php?select=comments'>here</a> to go back.";
}
else {
$query3 = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$result3 = mysql_fetch_array($query3);
$news_id = $result['id'];
$comment = safe($_POST['comment']);
$poster = $_SESSION['name'];
$rank = $result3['rank'];
$avatar = $result3['avatar'];
if($comment=='') {
echo "Please enter a comment. Click <a href='news.php?select=comment'>here</a> to go back.";
}
else {
mysql_query("INSERT INTO `comments` (`news_id`, `comment`, `poster`, `rank`, `avatar`) VALUES ('".$news_id."',\"".$comment."\", '".$poster."',
 '".$rank."', '".$avatar."')") or die(mysql_error());
header("Location: news.php?select=comments");
}
}
}
else {
echo "Please log in first.";
}
}
else {
?>
Enter your comment below!<br>
<form name="news_post" action="<?php echo safe($_SERVER['PHP_SELF']); ?>" method="post"> 
<img src='images/smilies/smile.png' alt=':)' onclick="document.forms.news_post.comment.value += ':)'" class='comment' />
<img src='images/smilies/sad.png' alt=':(' onclick="document.forms.news_post.comment.value += ':('" class='comment' />
<img src='images/smilies/mad.png' alt=':@' onclick="document.forms.news_post.comment.value += ':@'" class='comment' />
<img src='images/smilies/yikes.png' alt=':O' onclick="document.forms.news_post.comment.value += ':O'" class='comment' />
<img src='images/smilies/wink.png' alt=';)' onclick="document.forms.news_post.comment.value += ';)'" class='comment' />
<img src='images/smilies/big_smile.png' alt=':D' onclick="document.forms.news_post.comment.value += ':D'" class='comment' />
<img src='images/smilies/lol.png' alt='8D' onclick="document.forms.news_post.comment.value += '8D'" class='comment' />
<img src='images/smilies/hmm.png' alt=':/' onclick="document.forms.news_post.comment.value += ':/'" class='comment' />
<img src='images/smilies/tongue.png' alt=':P' onclick="document.forms.news_post.comment.value += ':P'" class='comment' /><br>
<textarea cols="50" rows="10" name="comment" maxlength='255'></textarea><br /> 
<input type="submit" name="submit" value="Post!" /> 
</form> 
<?php
}
?>

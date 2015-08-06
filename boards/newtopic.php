<?php
require('require/top.php');
$var = safe($_GET['for']);
$q1 = mysql_query("SELECT * FROM `forums` WHERE `id`='".$var."'");
$r1 = mysql_fetch_array($q1);
$c1 = mysql_num_rows($q1);
if($c1=="1") {
$q2 = mysql_query("SELECT * FROM `users` WHERE `id`='".$_SESSION['id']."'");
$r2 = mysql_fetch_array($q2);
if($r2['rank']=="Member") {
if($r1['mem_post']=="0") {
echo "You are unallowed to post in this forum.";
require('require/bottom.php');
die();
}
}
if(isset($_POST['submit'])) {
$title = safe($_POST['title']);
$post = safe($_POST['comment']);
if($title=='') {
echo "Please enter a title.";
}
elseif($post=='') {
echo "Please enter text.";
}
else {
mysql_query("INSERT INTO `posts` (`poster`, `post`, `type`, `title`, `forum`) VALUES ('".$_SESSION['name']."', '".$post."', 'topic', '".$title."', '".$r1['id']."')") or die(mysql_error());
echo "Topic posted.";
}
}
else {
?>
<form name="news_post" action="newtopic.php?for=<?php echo $var; ?>" method="post"><fieldset><legend>Post a Topic</legend>
<b>Title</b>:<br>
<input type='text' name='title' maxlength='25'><br><br>
<b>Post</b>:<br>
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
</fieldset>
<?php
}
}
else {
echo "This forum does not exist.";
}
require('require/bottom.php');
?>

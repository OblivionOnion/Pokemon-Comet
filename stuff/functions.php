<?php   
 function parseBBCode($data) {
        $BBCODE = array();
        $BBCODE_REPLACEMENT = array();
        $BBCODE[]             = '/\[i\](.*?)\[\/i\]/';
        $BBCODE_REPLACEMENT[] = '<em>$1</em>';
        $BBCODE[]             = '/\[u\](.*?)\[\/u\]/';
        $BBCODE_REPLACEMENT[] = '<span style="text-decoration: underline;">$1</span>';
        $BBCODE[]             = '/\[s\](.*?)\[\/s\]/';
        $BBCODE_REPLACEMENT[] = '<span style="text-decoration: line-through;">$1</span>';
        $BBCODE[]             = '/\[em\](.*?)\[\/em\]/';
        $BBCODE_REPLACEMENT[] = '<em>$1</em>';
        $BBCODE[]             = '/\[strong\](.*?)\[\/strong\]/';
        $BBCODE_REPLACEMENT[] = '<strong>$1</strong>';
        $BBCODE[]             = '/\[b\](.*?)\[\/b\]/';
        $BBCODE_REPLACEMENT[] = '<strong>$1</strong>';
        $BBCODE[]             = '/\[img\](.*?)\[\/img\]/';
        $BBCODE_REPLACEMENT[] = '<img src="$1" alt="User Posted Image" />';
        //$BBCODE[]             = '/\[img=(.*?)\](.*?)\[\/img\]/';
        //$BBCODE_REPLACEMENT[] = '<img src="$1" alt="User Posted Image" title="$2" />';
        //$BBCODE[]             = '/(http:\/\/[a-zA-Z0-9\?#\/\._\-\+=\|&;]+)/';
        //$BBCODE_REPLACEMENT[] = '[url=$1]Link[/url]';
        $BBCODE[]             = '/\[url=(.*?)\](.*?)\[\/url\]/';
        $BBCODE_REPLACEMENT[] = '<a href="$1" target="_blank">$2</a>';
        $BBCODE[]             = '/\[comment\](.*?)\[\/comment\]/';
        $BBCODE_REPLACEMENT[] = '<!-- $1 -->';
        $BBCODE[]             = '/\[heading=(.*?)\](.*?)\[\/heading\]/';
        $BBCODE_REPLACEMENT[] = '<h3 id="heading:$1"><a href="#heading:$1">$2</a></h3>';
        $BBCODE[]             = '/\[spoiler\](.*?)\[\/spoiler\]/';
        $BBCODE_REPLACEMENT[] = '{Spoiler:<span class="spoiler">$1</span>}';
        $BBCODE[]             = '/\[colou?r=(.*?)\](.*?)\[\/colou?r\]/';
        $BBCODE_REPLACEMENT[] = '<span style="color: $1;">$2</span>';
        $BBCODE[]             = '/\[quote\](.*?)\[\/quote\]/';
        $BBCODE_REPLACEMENT[] = '<div class="quote">$1</div>';
        $BBCODE[]             = '/\[quote=(.*?)\](.*?)\[\/quote\]/';
        $BBCODE_REPLACEMENT[] = '<em>$1</em> said:<div class="quote">$2</div>';
        $BBCODE[]             = '/\[collapse\](.*?)\[\/collapse\]/';
        $BBCODE_REPLACEMENT[] = '<div class="collapse">$1</div>';
        
        $BBCODE[]             = '/\[user=(.*?)\](.*?)\[\/user\]/';
        $BBCODE_REPLACEMENT[] = '<a href="http://pokemonparadise.net/User/$1" class="profileLink">$2</a>';
        
        $SMILEYS = array();
        $SMILEYS_REPLACE = array();
        $SMILEYS[]         = ':)';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/smile.png"  alt=":)" />';
        $SMILEYS[]         = ':(';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/sad.png"  alt=":(" />';
        $SMILEYS[]         = ':@';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/mad.png"  alt=":@" />';
        $SMILEYS[]         = ':O';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/yikes.png"  alt=":O" />';
        $SMILEYS[]         = ';)';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/wink.png"  alt=";)" />';
        $SMILEYS[]         = ':D';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/big_smile.png"  alt=":D" />';
        $SMILEYS[]         = ':P';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/tongue.png"  alt=":P" />';
        $SMILEYS[]         = '8D';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/lol.png"  alt=":P" />';   
        $SMILEYS[]         = ':?';
        $SMILEYS_REPLACE[] = '<img src="images/smilies/hmm.png"  alt=":?" />';     

        $CENSORS = array();
        $CENSORS_REPLACE = array();
        $CENSORS[] = 'bitch';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'fuck';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'shit';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'nigger';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'cunt';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'dick';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'douche';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'cock';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'slut';
        $CENSORS_REPLACE[] = '*****';
        $CENSORS[] = 'penis';
        $CENSORS_REPLACE[] = '*****';
  
        //New lines, double spaces
        $data = htmlentities($data, ENT_NOQUOTES, 'utf-8');
        $data = str_replace(array("\n",'  '),array('<br />',' &nbsp;'),$data);
        //Replace curses
        $data = str_ireplace($CENSORS,$CENSORS_REPLACE,$data);
        //Replace tags
        $data = preg_replace($BBCODE,$BBCODE_REPLACEMENT,$data);
        //Replace smileys
        $data = str_replace($SMILEYS,$SMILEYS_REPLACE,$data);
        return $data;
}

function safe($data){
  // Fix &entity\n;
  $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
  $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
  $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
  $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
  
  // Remove any attribute starting with "on" or xmlns
  $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
  
  // Remove javascript: and vbscript: protocols
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
  
  // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
  
  // Remove namespaced elements (we do not need them)
  $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
  
  do
  {
          // Remove really unwanted tags
          $old_data = $data;
          $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
  }
  while ($old_data !== $data);

  mysql_real_escape_string($data);
  
  // we are done...
  return stripslashes($data);
}

$q = mysql_query("SELECT * FROM `users` WHERE `rank`='Banned'");
while($row = mysql_fetch_array($q)) {
if($_SERVER['REMOTE_ADDR']==$row['ip']) {
echo "";
die();
}
}

$query1 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='1'");
$result1 = mysql_num_rows($query1);
$query2 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='2'");
$result2 = mysql_num_rows($query2);
$query3 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='3'");
$result3 = mysql_num_rows($query3);
$query4 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='4'");
$result4 = mysql_num_rows($query4);
$query5 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='5'");
$result5 = mysql_num_rows($query5);
$query6 = mysql_query("SELECT * FROM `pokemon` WHERE `owner`='".$_SESSION['name']."' AND `position`='6'");
$result6 = mysql_num_rows($query6);
if($result1=="0") {
$spot = "1";
}
elseif($result2=="0") {
$spot = "2";
}
elseif($result3=="0") {
$spot = "3";
}
elseif($result4=="0") {
$spot = "4";
}
elseif($result5=="0") {
$spot = "5";
}
elseif($result6=="0") {
$spot = "6";
}
else {
$spot = "box";
}

function rank($data) {
        $RANK = array();
        $RANK_REPLACE = array();
        $RANK[] = 'Administrator';
        $RANK_REPLACE[] = "<font color='red'>Administrator</font>";
        $RANK[] = 'Moderator';
        $RANK_REPLACE[] = "<font color='purple'>Moderator</font>";
        $RANK[] = 'Chat Mod';
        $RANK_REPLACE[] = "<font color='yellow'>Chat Mod</font>";
        $RANK[] = 'Member';
        $RANK_REPLACE[] = "<font color='green'>Member</font>";
        $RANK[] = 'Tester';
        $RANK_REPLACE[] = "<font color='#FF00CC'>Tester</font>";

        $data = str_ireplace($RANK,$RANK_REPLACE,$data);
        return $data;
}
?>

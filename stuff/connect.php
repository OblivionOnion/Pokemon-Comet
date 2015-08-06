<?php
$database_host = 'mysql17.000webhost.com';
$database_user = 'a2091480_cmt';
$database_password = 'password1';
$database_name = 'a2091480_cmt';

$con = mysql_connect($database_host, $database_user, $database_password) or exit(mysql_error());
mysql_select_db($database_name, $con) or exit (mysql_error());

function db_query($sql)
{
  return mysql_query($sql, $GLOBALS['con']);
}

?>

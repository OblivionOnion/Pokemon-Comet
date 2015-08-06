</td>
<td colspan='1' id='rightmenu' cellspacing='0' cellpadding='0' valign='top'>
<?php
$query = mysql_query("SELECT * FROM `users`");
$check = mysql_num_rows($query);
if(isset($_SESSION['id'])) {
$time = time();
$time2 = $time-300;
$date = date('d/m/y');
$query2 = mysql_query("SELECT * FROM `users` WHERE `date`='".$date."' AND `time`>='".$time2."'");
$check2 = mysql_num_rows($query2);
?>
<h1>My Account</h1>
<a href="profile.php?id=<?php echo $_SESSION['id']; ?>">My Profile</a><br>
<a href='change_roster.php'>Change Party</a><br>
<a href='edit_avy.php'>Edit Avatar</a><br>
<a href='edit_sig.php'>Edit Signature</a><br>
<a href='findprof.php'>Find A Profile</a><br><br>
<h1>Explore</h1>
<a href='map.php?id=1'>Map #1</a><br><br>
<h1>Trades</h1>
<a href='trade.php?select=pending'>Trades to You</a><br>
<a href='trade.php?select=create'>Create a Trade</a><br>
<a href='stats.php?stat=pokemon'>Pokemon Ranks</a><br><br>
<h1>Statistics</h1>
Total Users: <?php echo $check; ?><br>
<a href="o_users.php">Online Users: <?php echo $check2; ?></a>
<?php
}
else {
?>
<h1>Main</h1>
<a href='index.php'>Homepage</a><br>
<a href='register.php'>Sign Up</a><br>
<a href='login.php'>Login</a>
<?php
}
?>
</td></tr>
<tr>
<td colspan='3' id='footer' cellspacing='0' cellpadding='0' valign='top'>
The Pokemon Comet is &copy; 2010 by Shadow. All images/icons/etc are &copy; of their respective owners.
</td></tr></table>
</div>
</body>
</html>

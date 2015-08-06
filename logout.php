<?php

session_start();

unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['time']);
unset($_SESSION['rand']);
header("Location: index.php");

?>

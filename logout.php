<?php
session_unset();
$_SESSION =[];
session_destroy();
header("Location: login.php");
sleep(.5);
exit();
?>
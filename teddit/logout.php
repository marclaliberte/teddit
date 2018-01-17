<?php
session_start();
unset($_SESSION['username']);
session_destroy();
$host = $_SERVER['HTTP_HOST'];
header("Location: http://$host/");
exit;

?>

<?php
require_once 'classes/Session.php';

Session::start();
Session::destroy();

header("Location: login.php");
?>

<?php
session_start();
?>

<?php
unset($_SESSION['message']);
session_unset();
session_destroy();
header('Location: login.php');
?>

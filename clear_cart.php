<?php
session_start();
unset($_SESSION['cart']);
header("Location: dangky.php");
?>
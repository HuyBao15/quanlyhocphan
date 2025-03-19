<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['cart']); // Xóa giỏ hàng nếu có
header("Location: home.php");
exit;
?>
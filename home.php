<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ - Quản lý học phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .menu {
            margin: 20px auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .menu a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-decoration: none;
            color: #007BFF;
            background-color: #fff;
            border: 1px solid #007BFF;
            border-radius: 3px;
        }
        .menu a:hover {
            background-color: #007BFF;
            color: #fff;
        }
        .logout {
            color: #dc3545;
            border-color: #dc3545;
        }
        .logout:hover {
            background-color: #dc3545;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Quản lý học phần</h1>
    <div class="menu">
        <?php if(isset($_SESSION['user'])) { ?>
            <p>Xin chào, <?php echo $_SESSION['user']; ?>!</p>
            <a href="index.php">Quản lý sinh viên</a>
            <a href="dangky.php">Đăng ký học phần</a>
            <a href="logout.php" class="logout">Đăng xuất</a>
        <?php } else { ?>
            <p>Vui lòng đăng nhập để sử dụng hệ thống.</p>
            <a href="login.php">Đăng nhập</a>
        <?php } ?>
    </div>
</body>
</html>
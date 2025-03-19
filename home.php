<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Quản lý học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header {
            background: linear-gradient(90deg, #007bff, #00c4ff);
            color: white;
            padding: 2rem 0;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }
        .menu-container {
            max-width: 500px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .menu-container:hover {
            transform: translateY(-5px);
        }
        .menu-container p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 1.5rem;
        }
        .menu-container a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 0.75rem 0;
            padding: 0.75rem;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .menu-container a.btn-primary {
            background-color: #007bff;
            border: none;
            color: white;
        }
        .menu-container a.btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
        .menu-container a.btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
        }
        .menu-container a.btn-danger:hover {
            background-color: #b02a37;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
        .footer {
            margin-top: 2rem;
            padding: 1rem;
            text-align: center;
            color: #777;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Quản lý học phần</h1>
    </div>

    <!-- Menu -->
    <div class="menu-container">
        <?php if(isset($_SESSION['user'])) { ?>
            <p><i class="fas fa-user-circle me-2"></i>Xin chào, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
            <a href="index.php" class="btn btn-primary"><i class="fas fa-users me-2"></i>Quản lý sinh viên</a>
            <a href="dangky.php" class="btn btn-primary"><i class="fas fa-book me-2"></i>Đăng ký học phần</a>
            <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a>
        <?php } else { ?>
            <p><i class="fas fa-info-circle me-2"></i>Vui lòng đăng nhập để sử dụng hệ thống.</p>
            <a href="login.php" class="btn btn-primary"><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</a>
        <?php } ?>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 - Hệ thống quản lý học phần | Được phát triển bởi xAI
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
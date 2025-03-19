<?php
session_start();
include 'config.php';

if(!empty($_SESSION['cart']) && isset($_SESSION['user'])) {
    $maSV = $_SESSION['user'];
    $ngayDK = date('Y-m-d');
    
    // Thêm vào bảng DangKy
    $sql = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $ngayDK, $maSV);
    $stmt->execute();
    $maDK = $conn->insert_id;
    
    // Thêm chi tiết đăng ký và cập nhật số lượng
    foreach($_SESSION['cart'] as $maHP) {
        $sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $maDK, $maHP);
        $stmt->execute();
        
        $conn->query("UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP = '$maHP'");
    }
    
    unset($_SESSION['cart']);
    $success = "Đăng ký học phần thành công!";
} else {
    $error = "Không có học phần nào trong giỏ hàng hoặc bạn chưa đăng nhập.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lưu đăng ký học phần</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .message-container {
            max-width: 500px;
            width: 100%;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .message-container:hover {
            transform: translateY(-5px);
        }
        .message-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .success .message-icon {
            color: #28a745;
        }
        .error .message-icon {
            color: #dc3545;
        }
        .message-text {
            font-size: 1.2rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }
        .success .message-text {
            color: #28a745;
        }
        .error .message-text {
            color: #dc3545;
        }
        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
    </style>
</head>
<body>
    <!-- Message Container -->
    <div class="message-container <?php echo isset($success) ? 'success' : 'error'; ?>">
        <i class="message-icon fas <?php echo isset($success) ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
        <div class="message-text">
            <?php 
            if(isset($success)) {
                echo htmlspecialchars($success);
            } else {
                echo htmlspecialchars($error);
            }
            ?>
        </div>
        <a href="dangky.php" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
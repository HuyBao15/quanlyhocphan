<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])) {
    header("Location: login.php");
}

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_GET['add'])) {
    $maHP = $_GET['add'];
    if(!in_array($maHP, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $maHP;
    }
}

if(isset($_GET['remove'])) {
    $maHP = $_GET['remove'];
    $key = array_search($maHP, $_SESSION['cart']);
    if($key !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$hocphan = $conn->query("SELECT * FROM HocPhan");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký học phần</title>
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
        .header h2 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 15px;
        }
        .table-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
        }
        .table td, .table th {
            padding: 12px;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background-color: #f1faff;
        }
        .btn-action {
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .btn-add {
            background-color: #28a745;
            color: white;
        }
        .btn-add:hover {
            background-color: #218838;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
        .btn-remove {
            background-color: #dc3545;
            color: white;
        }
        .btn-remove:hover {
            background-color: #b02a37;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
        .btn-save, .btn-clear {
            margin: 0 5px;
            padding: 8px 15px;
            font-size: 1rem;
            border-radius: 5px;
        }
        .btn-save {
            background-color: #007bff;
            color: white;
        }
        .btn-save:hover {
            background-color: #0056b3;
        }
        .btn-clear {
            background-color: #dc3545;
            color: white;
        }
        .btn-clear:hover {
            background-color: #b02a37;
        }
        .back-link {
            display: inline-block;
            margin: 1rem 0;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .empty-cart {
            text-align: center;
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>Đăng ký học phần</h2>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Danh sách học phần -->
        <div class="table-container">
            <h3 class="mb-4">Danh sách học phần</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên HP</th>
                        <th>Số tín chỉ</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $hocphan->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['MaHP']); ?></td>
                        <td><?php echo htmlspecialchars($row['TenHP']); ?></td>
                        <td><?php echo htmlspecialchars($row['SoTinChi']); ?></td>
                        <td><?php echo isset($row['SoLuong']) ? htmlspecialchars($row['SoLuong']) : 'Chưa có dữ liệu'; ?></td>
                        <td>
                            <?php if(isset($row['SoLuong']) && $row['SoLuong'] > 0) { ?>
                                <a href="dangky.php?add=<?php echo htmlspecialchars($row['MaHP']); ?>" class="btn btn-action btn-add">
                                    <i class="fas fa-plus me-1"></i>Thêm
                                </a>
                            <?php } else { ?>
                                <span class="text-danger">Hết chỗ</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Giỏ hàng -->
        <div class="table-container">
            <h3 class="mb-4">Giỏ hàng</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã HP</th>
                        <th>Tên HP</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(!empty($_SESSION['cart'])) {
                        $cart_items = implode("','", $_SESSION['cart']);
                        $cart = $conn->query("SELECT * FROM HocPhan WHERE MaHP IN ('$cart_items')");
                        while($row = $cart->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['MaHP']); ?></td>
                            <td><?php echo htmlspecialchars($row['TenHP']); ?></td>
                            <td>
                                <a href="dangky.php?remove=<?php echo htmlspecialchars($row['MaHP']); ?>" class="btn btn-action btn-remove">
                                    <i class="fas fa-trash-alt me-1"></i>Xóa
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3" class="text-center">
                                <a href="save_dangky.php" class="btn btn-save">
                                    <i class="fas fa-save me-1"></i>Lưu đăng ký
                                </a>
                                <a href="clear_cart.php" class="btn btn-clear">
                                    <i class="fas fa-trash me-1"></i>Xóa tất cả
                                </a>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td colspan="3" class="empty-cart">Giỏ hàng trống</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Back to Home -->
        <a href="home.php" class="back-link"><i class="fas fa-arrow-left me-1"></i>Quay về trang chủ</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
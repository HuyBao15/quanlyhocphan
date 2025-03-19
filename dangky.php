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
<html>
<head>
    <title>Đăng ký học phần</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { margin-right: 10px; }
    </style>
</head>
<body>
    <h2>Đăng ký học phần</h2>
    <table border="1">
        <tr>
            <th>Mã HP</th>
            <th>Tên HP</th>
            <th>Số tín chỉ</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
        <?php while($row = $hocphan->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['MaHP']; ?></td>
            <td><?php echo $row['TenHP']; ?></td>
            <td><?php echo $row['SoTinChi']; ?></td>
            <td><?php echo isset($row['SoLuong']) ? $row['SoLuong'] : 'Chưa có dữ liệu'; ?></td>
            <td>
                <?php if(isset($row['SoLuong']) && $row['SoLuong'] > 0) { ?>
                    <a href="dangky.php?add=<?php echo $row['MaHP']; ?>">Thêm</a>
                <?php } else { ?>
                    Hết chỗ
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <h3>Giỏ hàng</h3>
    <table border="1">
        <?php 
        if(!empty($_SESSION['cart'])) {
            $cart_items = implode("','", $_SESSION['cart']);
            $cart = $conn->query("SELECT * FROM HocPhan WHERE MaHP IN ('$cart_items')");
            while($row = $cart->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['MaHP']; ?></td>
                <td><?php echo $row['TenHP']; ?></td>
                <td><a href="dangky.php?remove=<?php echo $row['MaHP']; ?>">Xóa</a></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="3">
                    <a href="save_dangky.php">Lưu đăng ký</a>
                    <a href="clear_cart.php">Xóa tất cả</a>
                </td>
            </tr>
        <?php } else {
            echo "Giỏ hàng trống";
        } ?>
    </table>
    <a href="home.php">Quay về trang chủ</a>
</body>
</html>
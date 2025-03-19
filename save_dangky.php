<?php
session_start();
include 'config.php';

if(!empty($_SESSION['cart']) && isset($_SESSION['user'])) {
    $maSV = $_SESSION['user'];
    $ngayDK = date('Y-m-d');
    
    $sql = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $ngayDK, $maSV);
    $stmt->execute();
    $maDK = $conn->insert_id;
    
    foreach($_SESSION['cart'] as $maHP) {
        $sql = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $maDK, $maHP);
        $stmt->execute();
        
        $conn->query("UPDATE HocPhan SET SoLuong = SoLuong - 1 WHERE MaHP = '$maHP'");
    }
    
    unset($_SESSION['cart']);
    echo "Đăng ký thành công!";
    echo "<a href='dangky.php'>Quay lại</a>";
}
?>
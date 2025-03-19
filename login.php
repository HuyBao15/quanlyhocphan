<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST['MaSV'];
    $sql = "SELECT * FROM SinhVien WHERE MaSV = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $maSV);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $_SESSION['user'] = $maSV;
        header("Location: dangky.php");
    } else {
        echo "Đăng nhập thất bại!";
    }
}
?>
<form method="post">
    Mã SV: <input type="text" name="MaSV"><br>
    <input type="submit" value="Đăng nhập">
</form>
<a href="home.php">Quay về trang chủ</a>
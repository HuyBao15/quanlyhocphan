<?php
include 'config.php';
$id = $_GET['id'];
$sql = "SELECT sv.*, nh.TenNganh FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh WHERE MaSV=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thông tin sinh viên</title>
    <style>
        img { width: 150px; height: 150px; object-fit: cover; margin: 10px 0; }
    </style>
</head>
<body>
    <h2>Thông tin sinh viên</h2>
    Mã SV: <?php echo $row['MaSV']; ?><br>
    Họ Tên: <?php echo $row['HoTen']; ?><br>
    Giới Tính: <?php echo $row['GioiTinh']; ?><br>
    Ngày Sinh: <?php echo $row['NgaySinh']; ?><br>
    Hình ảnh: <br><img src="<?php echo $row['Hinh']; ?>" alt="Ảnh SV"><br>
    Ngành Học: <?php echo $row['TenNganh']; ?><br>
    <a href="index.php">Quay lại</a>
</body>
<!-- Thêm vào cuối thẻ body -->
<a href="home.php">Quay về trang chủ</a>
</html>
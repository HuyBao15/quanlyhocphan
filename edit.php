<?php
include 'config.php';
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST['MaSV'];
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];
    $hinh = $_POST['HinhCu']; // Giữ ảnh cũ nếu không upload ảnh mới

    // Xử lý upload hình ảnh mới
    if(isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            if(move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
                $hinh = $target_file;
            }
        }
    }

    $sql = "UPDATE SinhVien SET HoTen=?, GioiTinh=?, NgaySinh=?, Hinh=?, MaNganh=? WHERE MaSV=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh, $maSV);
    
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$sv = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$id'")->fetch_assoc();
$nganh = $conn->query("SELECT * FROM NganhHoc");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sửa sinh viên</title>
</head>
<body>
    <h2>Sửa thông tin sinh viên</h2>
    <form method="post" enctype="multipart/form-data">
        Mã SV: <input type="text" name="MaSV" value="<?php echo $sv['MaSV']; ?>" readonly><br>
        Họ Tên: <input type="text" name="HoTen" value="<?php echo $sv['HoTen']; ?>" required><br>
        Giới Tính: <input type="text" name="GioiTinh" value="<?php echo $sv['GioiTinh']; ?>" required><br>
        Ngày Sinh: <input type="date" name="NgaySinh" value="<?php echo $sv['NgaySinh']; ?>" required><br>
        Hình ảnh hiện tại: <img src="<?php echo $sv['Hinh']; ?>" width="100"><br>
        <input type="hidden" name="HinhCu" value="<?php echo $sv['Hinh']; ?>">
        Hình ảnh mới: <input type="file" name="Hinh" accept="image/*"><br>
        Ngành Học: 
        <select name="MaNganh" required>
            <?php while($row = $nganh->fetch_assoc()) { ?>
                <option value="<?php echo $row['MaNganh']; ?>" <?php if($row['MaNganh'] == $sv['MaNganh']) echo 'selected'; ?>>
                    <?php echo $row['TenNganh']; ?>
                </option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Cập nhật">
    </form>
    <a href="index.php">Quay lại</a>
</body>
<!-- Thêm vào cuối thẻ body -->
<a href="home.php">Quay về trang chủ</a>
</html>
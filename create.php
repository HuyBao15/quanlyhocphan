<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST['MaSV'];
    $hoTen = $_POST['HoTen'];
    $gioiTinh = $_POST['GioiTinh'];
    $ngaySinh = $_POST['NgaySinh'];
    $maNganh = $_POST['MaNganh'];

    // Xử lý upload hình ảnh
    $hinh = '';
    if(isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Kiểm tra định dạng file
        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
            if(move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
                $hinh = $target_file;
            }
        }
    }

    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $maSV, $hoTen, $gioiTinh, $ngaySinh, $hinh, $maNganh);
    
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$nganh = $conn->query("SELECT * FROM NganhHoc");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm sinh viên</title>
</head>
<body>
    <h2>Thêm sinh viên mới</h2>
    <form method="post" enctype="multipart/form-data">
        Mã SV: <input type="text" name="MaSV" required><br>
        Họ Tên: <input type="text" name="HoTen" required><br>
        Giới Tính: <input type="text" name="GioiTinh" required><br>
        Ngày Sinh: <input type="date" name="NgaySinh" required><br>
        Hình ảnh: <input type="file" name="Hinh" accept="image/*" required><br>
        Ngành Học: 
        <select name="MaNganh" required>
            <?php while($row = $nganh->fetch_assoc()) { ?>
                <option value="<?php echo $row['MaNganh']; ?>"><?php echo $row['TenNganh']; ?></option>
            <?php } ?>
        </select><br>
        <input type="submit" value="Thêm">
    </form>
    <a href="index.php">Quay lại</a>
</body>
</html>
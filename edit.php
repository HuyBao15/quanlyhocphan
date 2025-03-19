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
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"][readonly] {
            background-color: #f0f0f0;
        }

        input[type="file"] {
            padding: 5px 0;
        }

        .image-preview img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .buttons {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            text-decoration: none;
            border-radius: 5px;
            background-color: #6c757d;
            color: white;
            transition: background-color 0.3s;
        }

        .buttons a:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sửa thông tin sinh viên</h2>
        <form method="post" enctype="multipart/form-data">
            <div>
                <label>Mã SV:</label>
                <input type="text" name="MaSV" value="<?php echo $sv['MaSV']; ?>" readonly>
            </div>
            
            <div>
                <label>Họ Tên:</label>
                <input type="text" name="HoTen" value="<?php echo $sv['HoTen']; ?>" required>
            </div>
            
            <div>
                <label>Giới Tính:</label>
                <input type="text" name="GioiTinh" value="<?php echo $sv['GioiTinh']; ?>" required>
            </div>
            
            <div>
                <label>Ngày Sinh:</label>
                <input type="date" name="NgaySinh" value="<?php echo $sv['NgaySinh']; ?>" required>
            </div>
            
            <div class="image-preview">
                <label>Hình ảnh hiện tại:</label>
                <img src="<?php echo $sv['Hinh']; ?>" alt="Ảnh hiện tại">
                <input type="hidden" name="HinhCu" value="<?php echo $sv['Hinh']; ?>">
            </div>
            
            <div>
                <label>Hình ảnh mới:</label>
                <input type="file" name="Hinh" accept="image/*">
            </div>
            
            <div>
                <label>Ngành Học:</label>
                <select name="MaNganh" required>
                    <?php while($row = $nganh->fetch_assoc()) { ?>
                        <option value="<?php echo $row['MaNganh']; ?>" <?php if($row['MaNganh'] == $sv['MaNganh']) echo 'selected'; ?>>
                            <?php echo $row['TenNganh']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="buttons">
                <input type="submit" value="Cập nhật">
                <a href="index.php">Quay lại</a>
                <a href="home.php">Quay về trang chủ</a>
            </div>
        </form>
    </div>
</body>
</html>
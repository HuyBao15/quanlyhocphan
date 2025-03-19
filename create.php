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
            } else {
                echo "Lỗi khi upload hình ảnh.";
            }
        } else {
            echo "Chỉ chấp nhận file JPG, JPEG, PNG.";
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
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sinh viên</title>
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
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .form-container:hover {
            transform: translateY(-5px);
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .btn-submit {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>Thêm sinh viên mới</h2>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="MaSV" class="form-label"><i class="fas fa-id-card me-2"></i>Mã SV</label>
                <input type="text" class="form-control" id="MaSV" name="MaSV" required>
            </div>
            <div class="mb-3">
                <label for="HoTen" class="form-label"><i class="fas fa-user me-2"></i>Họ Tên</label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" required>
            </div>
            <div class="mb-3">
                <label for="GioiTinh" class="form-label"><i class="fas fa-venus-mars me-2"></i>Giới Tính</label>
                <input type="text" class="form-control" id="GioiTinh" name="GioiTinh" required>
            </div>
            <div class="mb-3">
                <label for="NgaySinh" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Ngày Sinh</label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required>
            </div>
            <div class="mb-3">
                <label for="Hinh" class="form-label"><i class="fas fa-image me-2"></i>Hình ảnh</label>
                <input type="file" class="form-control" id="Hinh" name="Hinh" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="MaNganh" class="form-label"><i class="fas fa-graduation-cap me-2"></i>Ngành Học</label>
                <select class="form-select" id="MaNganh" name="MaNganh" required>
                    <?php while($row = $nganh->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($row['MaNganh']); ?>">
                            <?php echo htmlspecialchars($row['TenNganh']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-submit"><i class="fas fa-plus me-2"></i>Thêm</button>
        </form>
        <a href="home.php" class="back-link"><i class="fas fa-arrow-left me-1"></i>Quay về trang chủ</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
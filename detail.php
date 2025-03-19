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

        .student-info {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .student-info label {
            font-weight: bold;
            color: #555;
        }

        .student-info span {
            color: #333;
        }

        .student-image img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 10px 0;
        }

        .buttons {
            margin-top: 20px;
        }

        .buttons a {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .buttons a:first-child {
            background-color: #007bff;
            color: white;
        }

        .buttons a:last-child {
            background-color: #6c757d;
            color: white;
        }

        .buttons a:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông tin sinh viên</h2>
        <div class="student-info">
            <label>Mã SV:</label>
            <span><?php echo $row['MaSV']; ?></span>
            
            <label>Họ Tên:</label>
            <span><?php echo $row['HoTen']; ?></span>
            
            <label>Giới Tính:</label>
            <span><?php echo $row['GioiTinh']; ?></span>
            
            <label>Ngày Sinh:</label>
            <span><?php echo $row['NgaySinh']; ?></span>
            
            <label>Ngành Học:</label>
            <span><?php echo $row['TenNganh']; ?></span>
        </div>
        
        <div class="student-image">
            <label>Hình ảnh:</label><br>
            <img src="<?php echo $row['Hinh']; ?>" alt="Ảnh SV">
        </div>
        
        <div class="buttons">
            <a href="index.php">Quay lại</a>
            <a href="home.php">Quay về trang chủ</a>
        </div>
    </div>
</body>
</html>
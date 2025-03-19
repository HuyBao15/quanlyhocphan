<?php
include 'config.php';
$sql = "SELECT sv.*, nh.TenNganh FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên</title>
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
        .student-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #007bff;
        }
        .btn-action {
            padding: 5px 10px;
            font-size: 0.9rem;
            border-radius: 5px;
            margin: 0 3px;
            transition: all 0.3s ease;
        }
        .btn-detail {
            background-color: #17a2b8;
            color: white;
        }
        .btn-detail:hover {
            background-color: #138496;
            box-shadow: 0 2px 4px rgba(23, 162, 184, 0.3);
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background-color: #218838;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #b02a37;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }
        .btn-add {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-add:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h2>Danh sách sinh viên</h2>
    </div>

    <!-- Main Content -->
    <div class="container">
        <a href="create.php" class="btn-add"><i class="fas fa-user-plus me-2"></i>Thêm sinh viên mới</a>
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ Tên</th>
                        <th>Giới Tính</th>
                        <th>Ngày Sinh</th>
                        <th>Hình ảnh</th>
                        <th>Ngành Học</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['MaSV']); ?></td>
                        <td><?php echo htmlspecialchars($row['HoTen']); ?></td>
                        <td><?php echo htmlspecialchars($row['GioiTinh']); ?></td>
                        <td><?php echo htmlspecialchars($row['NgaySinh']); ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($row['Hinh']); ?>" alt="Ảnh SV" class="student-img">
                        </td>
                        <td><?php echo htmlspecialchars($row['TenNganh']); ?></td>
                        <td>
                            <a href="detail.php?id=<?php echo htmlspecialchars($row['MaSV']); ?>" class="btn btn-action btn-detail">
                                <i class="fas fa-eye me-1"></i>Chi tiết
                            </a>
                            <a href="edit.php?id=<?php echo htmlspecialchars($row['MaSV']); ?>" class="btn btn-action btn-edit">
                                <i class="fas fa-edit me-1"></i>Sửa
                            </a>
                            <a href="delete.php?id=<?php echo htmlspecialchars($row['MaSV']); ?>" class="btn btn-action btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                <i class="fas fa-trash-alt me-1"></i>Xóa
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <a href="home.php" class="back-link"><i class="fas fa-arrow-left me-1"></i>Quay về trang chủ</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include 'config.php';
$sql = "SELECT sv.*, nh.TenNganh FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Danh sách sinh viên</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { width: 50px; height: 50px; object-fit: cover; }
    </style>
</head>
<body>
    <h2>Danh sách sinh viên</h2>
    <a href="create.php">Thêm sinh viên mới</a>
    <table border="1">
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình ảnh</th>
            <th>Ngành Học</th>
            <th>Hành động</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['MaSV']; ?></td>
            <td><?php echo $row['HoTen']; ?></td>
            <td><?php echo $row['GioiTinh']; ?></td>
            <td><?php echo $row['NgaySinh']; ?></td>
            <td><img src="<?php echo $row['Hinh']; ?>" alt="Ảnh SV"></td>
            <td><?php echo $row['TenNganh']; ?></td>
            <td>
                <a href="detail.php?id=<?php echo $row['MaSV']; ?>">Chi tiết</a>
                <a href="edit.php?id=<?php echo $row['MaSV']; ?>">Sửa</a>
                <a href="delete.php?id=<?php echo $row['MaSV']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
<!-- Thêm vào cuối thẻ body -->
<a href="home.php">Quay về trang chủ</a>
</html>

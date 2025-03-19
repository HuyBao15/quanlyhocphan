<?php
include 'config.php';
$id = $_GET['id'];

// Lấy đường dẫn ảnh để xóa file
$sql = "SELECT Hinh FROM SinhVien WHERE MaSV=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$hinh = $row['Hinh'];

// Xóa sinh viên khỏi database
$sql = "DELETE FROM SinhVien WHERE MaSV=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
if ($stmt->execute()) {
    // Xóa file ảnh nếu tồn tại
    if(file_exists($hinh)) {
        unlink($hinh);
    }
    header("Location: index.php");
} else {
    echo "Lỗi: " . $conn->error;
}
?>
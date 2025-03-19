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
        $error = "Đăng nhập thất bại! Mã sinh viên không tồn tại.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .login-container:hover {
            transform: translateY(-5px);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h2 {
            color: #007bff;
            font-size: 1.8rem;
            font-weight: 700;
        }
        .login-header i {
            font-size: 2.5rem;
            color: #007bff;
            margin-bottom: 0.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .btn-login {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Login Container -->
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-sign-in-alt"></i>
            <h2>Đăng nhập</h2>
        </div>

        <?php if(isset($error)) { ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>

        <form method="post">
            <div class="mb-3">
                <label for="MaSV" class="form-label"><i class="fas fa-id-card me-2"></i>Mã SV</label>
                <input type="text" class="form-control" id="MaSV" name="MaSV" placeholder="Nhập mã sinh viên" required>
            </div>
            <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt me-2"></i>Đăng nhập</button>
        </form>
        <a href="home.php" class="back-link"><i class="fas fa-arrow-left me-1"></i>Quay về trang chủ</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
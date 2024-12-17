<?php
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Users WHERE UserID = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];
    $new_password = md5($_POST['password']); // Mã hóa mật khẩu mới

    // Cập nhật thông tin người dùng
    $update_sql = "UPDATE Users SET Email = '$new_email', Password = '$new_password' WHERE UserID = $user_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "Cập nhật thông tin thành công!";
        // Cập nhật lại thông tin session
        $_SESSION['username'] = $user['Username'];
    } else {
        echo "Lỗi cập nhật thông tin!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
</head>
<body>
    <h2>Thông tin tài khoản</h2>
    <form method="POST" action="">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['Username']; ?>" disabled><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['Email']; ?>" required><br><br>
        <label for="password">Mật khẩu mới:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Cập nhật</button>
    </form>
</body>
</html>

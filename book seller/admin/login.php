<?php
session_start();

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn cơ sở dữ liệu để kiểm tra thông tin người dùng
    $sql = "SELECT UserID, FullName, Email, Role FROM users WHERE Username = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password); // Tránh SQL Injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Lấy thông tin người dùng
        $user = $result->fetch_assoc();

        // Lưu thông tin người dùng vào session
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['Role']; // Lưu role vào session

        // Kiểm tra role, nếu là Admin (Role = 1) thì chuyển đến trang quản trị
        if ($user['Role'] == 1) {
            header("Location: admin_dashboard.php");
        } else {
            echo "Bạn không có quyền truy cập vào trang này.";
        }
    } else {
        echo "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f3f4f6;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.main-content {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px 30px;
    max-width: 400px;
    width: 100%;
}

h1 {
    text-align: center;
    color: #333333;
    margin-bottom: 20px;
}

form div {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555555;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #dddddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

p {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

a {
    color: #007BFF;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>

<body>


    <main class="main-content">
    <h1>Đăng Nhập</h1>
        <form method="POST" action="login.php">
            <div>
                <label for="username">Tên Đăng Nhập:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="password">Mật Khẩu:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <button type="submit">Đăng Nhập</button>
            </div>
            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>

        </form>
    </main>
</body>

</html>

<?php
session_start(); // Bắt đầu session

// Kiểm tra nếu đã đăng nhập thì chuyển đến trang chủ
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "BookStore");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE Username = '$username' AND Password = '" . md5($password) . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['UserID']; // Lưu thông tin người dùng vào session
        $_SESSION['username'] = $user['Username'];
        header("Location: index.php");
    } else {
        $error = "Sai tên đăng nhập hoặc mật khẩu!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<style>
    /* Tổng quát */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form đăng nhập */
.login-form {
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.login-form h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.login-form label {
    display: block;
    text-align: left;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.login-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
    box-sizing: border-box;
}

.login-form input:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
}

.login-form button {
    background: #007BFF;
    color: #fff;
    padding: 10px 15px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s ease;
}

.login-form button:hover {
    background: #0056b3;
}

.login-form p {
    font-size: 14px;
    color: #777;
    margin-top: 15px;
}

.login-form p a {
    color: #007BFF;
    text-decoration: none;
}

.login-form p a:hover {
    text-decoration: underline;
}

</style>
<body>
    <div class="login-form">
        <h2>Đăng nhập</h2>
        <form method="POST" action="">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Đăng nhập</button>
        </form>
        <p><?php if (isset($error)) echo $error; ?></p>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </div>
</body>
</html>

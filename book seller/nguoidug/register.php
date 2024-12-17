<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "BookStore");

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];

    // Kiểm tra xem tên đăng nhập đã tồn tại chưa
    $sql = "SELECT * FROM Users WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $password_hashed = md5($password); // Hash mật khẩu trước khi lưu
        $insert_sql = "INSERT INTO Users (Username, Password, FullName, Email) 
                       VALUES ('$username', '$password_hashed', '$fullName', '$email')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: login.php");
        } else {
            $error = "Đã xảy ra lỗi khi đăng ký!";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<style>
    /* Tổng quát */
body {
    font-family: Arial, sans-serif;
    background-color: #f7f9fc;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form đăng ký */
.register-form {
    background: #ffffff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.register-form h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
}

.register-form label {
    display: block;
    text-align: left;
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

.register-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
    box-sizing: border-box;
}

.register-form input:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 4px rgba(0, 123, 255, 0.5);
}

.register-form button {
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

.register-form button:hover {
    background: #0056b3;
}

.register-form p {
    font-size: 14px;
    color: #777;
    margin-top: 15px;
}

.register-form p a {
    color: #007BFF;
    text-decoration: none;
}

.register-form p a:hover {
    text-decoration: underline;
}

</style>
<body>
    <div class="register-form">
        <h2>Đăng ký</h2>
        <form method="POST" action="">
            <label for="full_name">Họ và tên:</label>
            <input type="text" id="full_name" name="full_name" required><br><br>
            <label for="username">Tên đăng nhập:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required><br><br>
            <button type="submit">Đăng ký</button>
        </form>
        <p><?php if (isset($error)) echo $error; ?></p>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </div>
</body>
</html>

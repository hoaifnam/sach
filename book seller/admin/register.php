<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng ký
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    // Kiểm tra xem người dùng đã tồn tại chưa
    $sql = "SELECT * FROM users WHERE Username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Tên đăng nhập đã tồn tại.";
    } else {
        // Nếu người dùng chưa tồn tại, chèn thông tin mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (Username, Password, FullName, Email, Role) VALUES (?, ?, ?, ?, 1)"; // Role = 0 cho người dùng bình thường
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $password, $fullname, $email);
        
        if ($stmt->execute()) {
            // Đăng ký thành công, ghi nhớ thông tin vào session
            session_start();
            $_SESSION['username'] = $username;  // Ghi nhớ tên người dùng
            $_SESSION['role'] = 1;  // Ghi nhớ role là 0 (người dùng bình thường)
            $_SESSION['registered'] = 1;  // Lưu trạng thái đăng ký thành công

            echo "Đăng ký thành công! Bạn có thể <a href='login.php'>đăng nhập</a> ngay.";
        } else {
            echo "Đã có lỗi xảy ra, vui lòng thử lại.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f9fafb;
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

input[type="text"], input[type="password"], input[type="email"] {
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
    background-color: #28a745;
    border: none;
    border-radius: 5px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    background-color: #218838;
}

p {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

a {
    color: #007bff;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>

<body>

    <main class="main-content">
        <form method="POST" action="register.php">
        <h1>Đăng Ký Tài Khoản</h1>
            <div>
                <label for="username">Tên Đăng Nhập:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="password">Mật Khẩu:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <label for="fullname">Họ và Tên:</label>
                <input type="text" name="fullname" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <button type="submit">Đăng Ký</button>
            </div>
            <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>

        </form>
    </main>
</body>

</html>

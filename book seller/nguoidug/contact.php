<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý lưu thông tin liên hệ
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Kiểm tra dữ liệu đầu vào
    if (empty($fullname) || empty($email) || empty($message)) {
        $error = "Vui lòng điền đầy đủ thông tin!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email không hợp lệ!";
    } else {
        $sql = "INSERT INTO contacts (FullName, Email, Message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sss", $fullname, $email, $message);
            if ($stmt->execute()) {
                $success = "Cảm ơn bạn đã liên hệ! Thông tin đã được gửi.";
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại!";
            }
            $stmt->close();
        } else {
            $error = "Không thể chuẩn bị câu lệnh!";
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
    <title>Liên Hệ</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    /* Tổng thể */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

/* Tiêu đề chính */
header {
    background-color: #007bff;
    color: #fff;
    padding: 20px 0;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

header h1 {
    margin: 0;
    font-size: 24px;
}

/* Nội dung chính */
.main-content {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    min-height: calc(100vh - 100px);
}

.contact-form {
    background: #fff;
    padding: 20px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 500px;
}

.contact-form h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #007bff;
}

/* Form styling */
.contact-form label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.contact-form input, 
.contact-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
    color: #333;
}

.contact-form textarea {
    resize: none;
}

/* Button */
.contact-form button {
    width: 100%;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.contact-form button:hover {
    background-color: #0056b3;
}

.contact-form button:active {
    background-color: #003f7f;
}

/* Thông báo */
.success {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #f5c6cb;
    border-radius: 5px;
}

/* Footer */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px 0;
}

footer p {
    margin: 0;
    font-size: 14px;
}

</style>
<body>
    <header>
        <div class="container">
            <h1>Liên Hệ Với Chúng Tôi</h1>
        </div>
    </header>

    <main class="main-content">
        <section class="contact-form">
            <h2>Gửi Thông Tin Liên Hệ</h2>

            <!-- Thông báo thành công hoặc lỗi -->
            <?php if (isset($success)) : ?>
                <p class="success"><?php echo $success; ?></p>
            <?php elseif (isset($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <!-- Form liên hệ -->
            <form method="POST" action="">
                <div>
                    <label for="fullname">Họ và Tên:</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Nhập họ tên của bạn" required>
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
                </div>
                <div>
                    <label for="message">Nội Dung:</label>
                    <textarea id="message" name="message" placeholder="Nhập nội dung liên hệ" rows="5" required></textarea>
                </div>
                <div>
                    <button type="submit">Gửi Liên Hệ</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>

</html>

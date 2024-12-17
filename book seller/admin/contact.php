<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';  // Lấy tên người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';  // Lấy role từ session (1 là admin)
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "BookStore");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách liên hệ từ cơ sở dữ liệu
$sql = "SELECT ContactID, FullName, Email, Message, CreatedAt FROM contacts ORDER BY CreatedAt DESC";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Liên Hệ</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Quản Lý Liên Hệ</h1>
        </div>
    </header>

    <main class="main-content">
        <section class="contact-list">
            <h2>Danh Sách Liên Hệ</h2>
            <a href="admin_dashboard.php" class="back-button">Quay lại</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ và Tên</th>
                        <th>Email</th>
                        <th>Nội Dung</th>
                        <th>Ngày Tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['ContactID']; ?></td>
                                <td><?php echo htmlspecialchars($row['FullName']); ?></td>
                                <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                <td><?php echo htmlspecialchars($row['Message']); ?></td>
                                <td><?php echo $row['CreatedAt']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5">Không có liên hệ nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>

</html>

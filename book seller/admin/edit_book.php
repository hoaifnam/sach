<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';  
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';  

$conn = new mysqli("localhost", "root", "", "BookStore");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    $sql = "SELECT * FROM Books WHERE BookID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Không tìm thấy sách.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID sách không hợp lệ.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Sách</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Chỉnh Sửa Sách</h1>
        </div>
    </header>

    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Trang Quản Trị</a></li>
                    <li><a href="admin_books.php">Quản Lý Sách</a></li>
                    <li><a href="admin_orders.php">Quản Lý Đơn Hàng</a></li>
                    <li><a href="admin_users.php">Quản Lý Người Dùng</a></li>
                    <li><a href="contact.php">Quản Lý Liên Hệ</a></li>
                    <?php if ($username): ?>
                        <li class="account-menu">
                            <a href="profile.php">Chào, <?php echo $username; ?></a>
                            <div class="dropdown-menu">
                                <?php if ($role == 1): ?>
                                <?php endif; ?>
                                <a href="logout.php">Đăng xuất</a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php">Đăng nhập</a></li>
                        <li><a href="register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <a href="admin_books.php" class="back-button">Quay lại</a>
            <form action="update_book.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book['BookID']); ?>">

                <label for="title">Tiêu Đề:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['Title']); ?>" required>

                <label for="author">Tác Giả:</label>
                <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['Author']); ?>" required>

                <label for="price">Giá:</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($book['Price']); ?>" required>

                <label for="category">Danh Mục:</label>
                <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($book['CategoryID']); ?>" required>

                <label for="publish_year">Năm Xuất Bản:</label>
                <input type="number" id="publish_year" name="publish_year" value="<?php echo htmlspecialchars($book['PublishYear']); ?>" required>

                <label for="publisher">Nhà Xuất Bản:</label>
                <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['Publisher']); ?>" required>

                <label for="stock">Số Lượng:</label>
                <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($book['Stock']); ?>" required>

                <label for="cover_image">Ảnh Bìa Hiện Tại:</label>
                <?php if (!empty($book['CoverImage'])): ?>
                    <img src="<?php echo htmlspecialchars($book['CoverImage']); ?>" alt="Ảnh bìa sách" style="max-width: 150px; display: block; margin-bottom: 10px;">
                <?php endif; ?>
                <label for="cover_image">Tải Lên Ảnh Mới (Nếu Có):</label>
                <input type="file" id="cover_image" name="cover_image">

                <button type="submit">Cập Nhật Sách</button>
            </form>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>
</html>

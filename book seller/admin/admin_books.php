<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';  // Lấy tên người dùng từ session
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';  // Lấy role từ session (1 là admin)
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sách - Trang Quản Trị</title>
    <link rel="stylesheet" href="style.css"> <!-- Đảm bảo rằng bạn đã thêm file style.css -->
</head>

<body>
    <header>
        <div class="container">
            <h1>Quản Lý Sách</h1>
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
                        <!-- Hiển thị tên tài khoản và menu thả xuống -->
                        <li class="account-menu">
                            <a href="profile.php">Chào, <?php echo $username; ?></a>
                            <div class="dropdown-menu">
                                <?php if ($role == 1): ?>
                                    <!-- Nếu là Admin, hiển thị biểu tượng Admin -->
                                <?php endif; ?>
                                <a href="logout.php">Đăng xuất</a> <!-- Đường dẫn đăng xuất -->
                            </div>
                        </li>
                    <?php else: ?>
                        <!-- Nếu chưa đăng nhập, hiển thị Đăng nhập và Đăng ký -->
                        <li><a href="login.php">Đăng nhập</a></li>
                        <li><a href="register.php">Đăng ký</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h2>Danh Sách Sách</h2>
            <a href="add_book.php" class="back-button">Thêm mới</a>

            <table class="book-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu Đề</th>
                        <th>Tác Giả</th>
                        <th>Giá</th>
                        <th>Ngày Thêm</th>
                        <th>Ảnh Bìa</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Kết nối cơ sở dữ liệu
                    $conn = new mysqli("localhost", "root", "", "BookStore");
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    // Lấy tất cả sách từ cơ sở dữ liệu
                    $sql = "SELECT * FROM Books";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $counter = 1;
                        while ($book = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $counter . "</td>
                                    <td>" . $book['Title'] . "</td>
                                    <td>" . $book['Author'] . "</td>
                                    <td>" . number_format($book['Price'], 0, ',', '.') . " VNĐ</td>
                                    <td>" . $book['CreatedAt'] . "</td>
                                    <td><img src='" . $book['CoverImage'] . "' alt='" . $book['Title'] . "' style='width: 50px;'></td>
                                    <td><a href='edit_book.php?book_id=" . $book['BookID'] . "'>Chỉnh sửa</a> | <a href='delete_book.php?book_id=" . $book['BookID'] . "'>Xóa</a></td>
                                  </tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='7'>Không có sách nào trong cơ sở dữ liệu.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </main>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 BookStore. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>
</body>

</html>
